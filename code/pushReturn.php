<?php

/**
 * @author      Vinay Gupta
 * @description This script checks the Return orders in log table and pushes unsuccessfull return orders into navision.
 */
define('MAGENTO', realpath(dirname(__FILE__).'/../'));
require_once MAGENTO . '/app/Mage.php';
Mage::app();

define('NAVISION_LIB', Mage::getBaseDir() . '/lib/');
include_once(NAVISION_LIB . "Navision/navisionClass.php");

$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
//$connection->query("UPDATE bestylish_naviconnect set xml_status = '1' WHERE xml_type='ReturnOrder' AND xml_status = '0' AND msg LIKE '%already exist.' "); 

$start = $argv[1];
if($start != '') {
	$orders = explode(",", $start);
} else {
//	die( "Please enter order increment id.\n" );
}

//$orders = array(700050181,700050151,700050293,700050323,700050178,700050289);

foreach ($orders as $incrementid) {
    
	$rmaorders = $connection->fetchAll("SELECT id FROM aw_rma_entity WHERE order_id='".$incrementid."' ");   
	foreach ($rmaorders as $rmaVal) {
		 $newRma = $rmaVal['id']; 	 
		 runReturnOrder($newRma);
		 
//		 echo "[" . date('Y-m-d H:i:s') . "] Pushed Return Rma ID: \t" . $incrementid ." = ". $newRma . "\n";	 
	}
}

function runReturnOrder($newRma,$logid='') {

	define('USERPWD', 'Smile\navsuperuser:erppass@217bestylish');
	$baseURL = 'http://121.240.116.214:7047/DynamicsNAV/WS/Smile%20Sales-Live/';
	$salesOrder = 'Codeunit/ReturnOrderInsert';

	stream_wrapper_unregister('http');
    stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");

	$_rmaRequest = Mage::getModel('awrma/entity')->load($newRma);
	$incrementid = $_rmaRequest->order_id;
	if($incrementid != '') {
		try {
			$client = new NTLMSoapClient($baseURL.$salesOrder);
			
			$rmaNo = $_rmaRequest->id;
			$customerId = $_rmaRequest->customer_id;
			$returnReasonCode  = $_rmaRequest->request_type;
			if($returnReasonCode == '' || $returnReasonCode == '0') $returnReasonCode = 1;
			$returnOrderStatus = $_rmaRequest->status;
			$returnType 	   = "Customer Return";
			$orderItemsArr = $_rmaRequest->order_items;

		  $orderItems = array();
		  foreach($orderItemsArr as $key=>$val) {
			$sofi =	Mage::getModel('sales/order_item')->load($key);
			$productOptions = $sofi->getProductOptions();
			if($sofi->getProductType()=="configurable"){
				$orderItems[$productOptions['simple_sku']] = $val; //$productOptions['product_calculations'];
			} else {
				$orderItems[$sofi->sku] = $val; //$productOptions['info_buyRequest']['qty'];
			}
		  }
			//echo $incrementid."\n";
			$order = Mage::getModel('sales/order')->loadByIncrementId($incrementid);
			$orderId = $order->getEntityId();
			$amount = ($order->getBaseGrandTotal() < 0) ? '0.00' : $order->getBaseGrandTotal();
			$billingAddress = $order->getBillingAddress();
            //print_r($billingAddress); die('line 81');        
			$shippingAddress = $order->getShippingAddress();        
			$regionCode = getRegionCode($billingAddress->getRegion());
			
			$cancelStatus  = $order->getStatus() == 'canceled' ? 'Yes' : 'No';        
			$customerGroup = $order->getCustomerGroupId()=='3' ? 'B2B' : 'B2C';
			$voucherCode = $order->getCouponCode();
			
			switch($order->getStoreId()){
				
				case 1: 
					$customerSource = 'B2C';
					break;
				
				case 2: 
					$customerSource = 'B2B';
					break;
				
				case 8: 
					$customerSource = 'Facebook';
					break;
			}
			$vendorcode = $order->getCustomerId();
			
			if($order->getCustomerGroupId()=="3"){
				$kioskid = $order->getCustomerEmail();
			}
			
			$handlingcharges = '';
			$shippingcharges = $order->getBaseShippingAmount();
		   
			$paymentType = $order->getPayment()->getMethod();
			$paymentGateway = ''; $paymentRefNo = '';
			if($paymentType=="checkmo") {
				$paymentType = 'COD';
			} else {
				$paymentType = 'Prepaid';
				$paymentGateway = $order->getPayment()->getMethod();
				$paymentRefNo = '';
			}
			
			$params = array();
			$params['returnOrder']['Customer']['WebCustomerID'] = $order->getCustomerId();
			$params['returnOrder']['Customer']['Title'] = $order->getCustomerPrefix();     
			$params['returnOrder']['Customer']['FirstName'] = $order->getCustomerFirstname(); 
			$params['returnOrder']['Customer']['LastName'] = $order->getCustomerLastname(); 
			$params['returnOrder']['Customer']['Address'] = utf8_encode(implode(" ",$billingAddress->getStreet()));  
			$params['returnOrder']['Customer']['PostCode'] = $billingAddress->getPostcode();
			$params['returnOrder']['Customer']['City'] = $billingAddress->getCity();
			$params['returnOrder']['Customer']['State'] = $regionCode;
			$params['returnOrder']['Customer']['Country'] = $billingAddress->getCountryId();
			$params['returnOrder']['Customer']['PhoneNo'] = $billingAddress->getTelephone();
			$params['returnOrder']['Customer']['MobileNo'] = $billingAddress->getMobile();
			$params['returnOrder']['Customer']['FaxNo'] = $billingAddress->getFax();
			$params['returnOrder']['Customer']['EMail'] = $order->getCustomerEmail();
			$params['returnOrder']['Customer']['CustomerGroup'] = $customerGroup; 
			$params['returnOrder']['Customer']['CustomerSource'] = $customerSource;              
			$params['returnOrder']['Customer']['KIOSKID'] = $kioskid;
			
			$params['returnOrder']['SalesHeader']['WebShopOrderNo'] = $incrementid; 
			$params['returnOrder']['SalesHeader']['RMANo'] = $rmaNo;
			$params['returnOrder']['SalesHeader']['Title'] = $shippingAddress->getPrefix();
			$params['returnOrder']['SalesHeader']['ShipToName'] = $shippingAddress->getFirstname();
			$params['returnOrder']['SalesHeader']['ShipToName2'] = $shippingAddress->getLastname();
			$params['returnOrder']['SalesHeader']['ShippingAddress'] = utf8_encode(implode(" ",$shippingAddress->getStreet()));
			$params['returnOrder']['SalesHeader']['ShipToPostCode'] = $shippingAddress->getPostcode();
			$params['returnOrder']['SalesHeader']['ShipToCity'] = $shippingAddress->getCity();
			$params['returnOrder']['SalesHeader']['ShipToState'] = getRegionCode($shippingAddress->getRegion());
			$params['returnOrder']['SalesHeader']['ShipToCountry'] = $shippingAddress->getCountryId();
			$params['returnOrder']['SalesHeader']['ShipToPhoneNo'] = $shippingAddress->getTelephone();
			$params['returnOrder']['SalesHeader']['ShipToMobileNo'] = $shippingAddress->getMobile();
			$params['returnOrder']['SalesHeader']['ShipToEMail'] = $order->getCustomerEmail();
		
			$params['returnOrder']['SalesHeader']['BillToName'] = $billingAddress->getFirstname(); 
			$params['returnOrder']['SalesHeader']['BillToAddress'] = utf8_encode(implode(" ",$billingAddress->getStreet()));
			$params['returnOrder']['SalesHeader']['BillToCity'] = $billingAddress->getCity();
			$params['returnOrder']['SalesHeader']['BillToPostCode'] = $billingAddress->getPostcode();
			$params['returnOrder']['SalesHeader']['BillToCountry'] = $billingAddress->getCountryId();
			
			$params['returnOrder']['SalesHeader']['PaymentMethod'] = $paymentType; 
			$params['returnOrder']['SalesHeader']['OrderStatus'] = getOrderStatus($order->getStatus()); 
			$params['returnOrder']['SalesHeader']['OrderDate'] = splitDate($order->getCreatedAt(),0);
			$params['returnOrder']['SalesHeader']['OrderTime'] = splitDate($order->getCreatedAt(),1);        
			$params['returnOrder']['SalesHeader']['OrderValue'] = $amount;
			
			$params['returnOrder']['SalesHeader']['ReturnReasonCode'] = $returnReasonCode;
			$params['returnOrder']['SalesHeader']['ReturnType'] = $returnType;
			$params['returnOrder']['SalesHeader']['ReturnOrderStatus'] = $returnOrderStatus;
			$params['returnOrder']['SalesHeader']['VoucherCode'] = $voucherCode;

			$i = 0;
			$ino = 1;                
			$items = $order->getAllItems();
			foreach ($items as $itemId => $item) {
				if($item->getProductType() == 'simple') {

					if(array_key_exists($item->getSku(), $orderItems)) {
					if($orderItems[$item->getSku()] > 0 ) {
						$unitprice = 0;
						// Load parent ID if available
						$parent = Mage::getModel('sales/order_item')->load($item->getParentItemId(), 'item_id');
						if($parent && $parent->getPriceInclTax() > 0) $unitprice = $parent->getPriceInclTax();

						if($unitprice < '0.001') $unitprice = $item->getBasePriceInclTax();
						$product= Mage::getModel('catalog/product')->load($item->product_id);
						$params['returnOrder']['SalesLine'][$i]['LineNo'] = $ino.'0000';
						$params['returnOrder']['SalesLine'][$i]['ItemType'] = 'Item';
						$params['returnOrder']['SalesLine'][$i]['ItemCode'] = $item->getSku(); 
						$params['returnOrder']['SalesLine'][$i]['Description'] = $item->getName();
						$params['returnOrder']['SalesLine'][$i]['Quantity'] = $orderItems[$item->getSku()]; //$item->getQtyOrdered();
						$params['returnOrder']['SalesLine'][$i]['MRP'] = $product->getPrice(); 
						$params['returnOrder']['SalesLine'][$i]['UnitAmount'] = $unitprice; 
						$params['returnOrder']['SalesLine'][$i]['DiscountAmount'] = $item->getDiscountAmount();
						$ino = $ino+1;
						$i = $i+1;
					}}
			   }         
			}

//print_r($params);
		   $result = $client->CreateReturnOrder($params);
		   
		   logMsg($incrementid, 'ReturnOrder', $result->return_value, 1, $logid);
			
		  } catch (Exception $e) {
			 logMsg($incrementid, 'ReturnOrder', $e->getMessage(), 0, $logid);
		  }
	}             
      stream_wrapper_restore('http');    
            
}

function logMsg($order_id, $xml_type, $msg, $xml_status=0, $logid='') {
echo $order_id." = ".$msg." = ".$xml_status."\n"; 
    	$collection  = Mage::getModel('naviconnect/naviconnect')->getCollection();
    	$collection->addFieldToFilter('order_id',array('eq'=>$order_id));
	$collection->addFieldToFilter('xml_type',array('eq'=>$xml_type));
	$collection->addFieldToFilter('xml_status',0);
		$arr = array();
		$arr = $collection->getData();
    if(!empty($arr)) {

        if($logid=='') $logid = $collection->getFirstItem()->getId();
        $model = Mage::getModel('naviconnect/naviconnect')->load($logid);
		$model->setData('msg',$msg);
		$model->setData('xml_status',$xml_status);
		$model->save();
      
    } else {

        $model = Mage::getModel('naviconnect/naviconnect');
        $model->setData(array(
                        'order_id'  =>   $order_id, 
                        'xml_type'  =>   $xml_type, 
                        'msg'       =>   $msg, 
                        'xml_status'=>   $xml_status, 
                        'nav_id'    =>   $nav_id, 
                        'created_date'=> date("Y-m-d H:i:s")
                        ));
        $model->save();                
    }
}


function getRegionCode($regionName) {
    $collection  = Mage::getModel('directory/region')->getCollection();
    $collection->addFieldToFilter('country_id',array('eq'=>'IN'));
    $collection->addFieldToFilter('default_name',array('eq'=>$regionName));        
    $regionArr = $collection->getData();
    return $regionArr[0]['code'];
} 

function splitDate($date,$key) {
	$newdate = date("Y-m-d H:i:s", strtotime($date) + 3600 * 5.5);
    $dt = explode(" ",$newdate);
    return trim($dt[$key]);
}

function getOrderStatus($orderKey) {
    if($orderKey=='pushed_to_nav') $orderKey = 'processing';
    $orderstatusArr = array(
                        'pending' => 'Pending',
                        'pending_payment' => 'Pending Payment',
                        'processing' => 'Processing',
                        'holded' => 'On Hold',                                 
                        'complete' => 'Shipped',
                        'closed' => 'Closed',
                        'canceled' => 'Cancelled',       
                        'payment_review' => 'Review'     
                       );
    return $orderstatusArr[$orderKey];
}
