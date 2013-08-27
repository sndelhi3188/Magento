<?php
define('MAGENTO', realpath(dirname(__FILE__).'/../'));
require_once MAGENTO . '/app/Mage.php';
Mage::app();

define('NAVISION_LIB', Mage::getBaseDir() . '/lib/');
include_once (NAVISION_LIB . "Navision/navisionClass.php");

// API Interface
define('USERPWD', 'Smile\navsuperuser:erppass@217bestylish');
$baseURL = 'http://121.240.116.214:7047/DynamicsNAV/WS/Style%20Genie-Live/';
$salesOrder = 'Codeunit/GetItemInventory';

$resource = Mage::getSingleton('core/resource');
$read = $resource->getConnection('catalog_read');
$salesTable = (string)Mage::getConfig()->getTablePrefix() . 'sales_flat_order_item';
$yesterday = date('Y-m-d', time() - 86000); // Yesterday's date
$select_simple_item = $read->select()->limit(40)
                           ->from($salesTable)
                           ->where("DATE(ADDTIME(`created_at`, '05:30:00')) = '" . $yesterday . "' AND `product_type` = 'simple'");

// echo $select_simple_item->assemble(); exit();
$res = $read->fetchAll( $select_simple_item );
foreach($res as $row) {
    updateStock($row['sku']);
}

function updateStock( $sku ) {
    $productId  = Mage::getModel('catalog/product')->getIdBySku($sku);
    $stockItem  = Mage::getModel('cataloginventory/stock_item')->load($productId, 'product_id');
    $mageQty    = (int) $stockItem->getQty(); $navQty     = getCurrentStock( $sku );
    $resQty     = getReservedQty( $sku ); $qtyDiff    = $navQty - $resQty; $setQty     = max($qtyDiff, 0);
    if($mageQty != $setQty) { // There is a difference. Lets update Magento
        // $stockItem->setQty($setQty)->setIsInStock((bool) $setQty)->save();
        logMsg('[UPDATED] ' . $sku . "\tMage: " . $mageQty ."\tNav: " . $navQty . "\tRes: " . $resQty);
    } else {
        logMsg('[SKIPPED] ' . $sku . "\tMage: " . $mageQty ."\tNav: " . $navQty . "\tRes: " . $resQty);
    }
}

function getReservedQty( $sku ) {
    $productId = Mage::getModel('catalog/product')->getIdBySku($sku);  
    $unprocessedStatuses = array('holded', 'fraud', 'payment_review', 'paypal_pending', 'pending', 'pending_payment');
    $qty = 0;
    $collection = Mage::getModel('sales/order')->getCollection()
        ->addAttributeToFilter('status', array('in' => $unprocessedStatuses));
    $collection->getSelect()
        ->join(array(
                'items' => $collection->getTable('sales/order_item')), 
                'main_table.entity_id = items.order_id', 
                array('product_id' => 'items.product_id', 'qty' => 'items.qty_ordered'))
        ->where('product_id = ?', $productId);

    foreach ($collection as $item) {
        $qty += (int)$item->getQty();
    }
    return $qty;
}

function getCurrentStock( $sku ) {
    global $baseURL, $salesOrder;    
    stream_wrapper_unregister('http');
    stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");

    $client = new NTLMSoapClient($baseURL . $salesOrder);
    $params['itemCode'] = $sku;
    try {
        $result = $client->GetA2TQty($params);
        return (int) $result->return_value;
    } catch (exception $e) {
        print_r($e->getMessage());
	return 0;
    }
}

function logMsg( $result ) {
    echo $result . "\n";
}
