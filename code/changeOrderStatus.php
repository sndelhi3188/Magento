<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors',1);
umask(0);

Mage::app('default');
$orderId = $argv[1];
$order = Mage::getModel('sales/order')->loadByIncrementID($orderId);
$status = $order->getState();
//echo "Status is : ".$status."\n";
if($status != 'canceled' && $status != 'complete' && $status != 'closed' ){
$state = 'processing';
$status ='processing';
$comment = "Invoice creted sucessfully";
$isCustomerNotified=true;
$order->setState($state,$status,$comment,$isCustomerNotified);
$order->save();
$order->sendOrderUpdateEmail(true,$comment);
//$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING,true)->save();
	echo "Status Updated to Processing Sucessfully. \n";
}else{
	echo "Order already Cancelled/Shipped/Refunded.\n";
}

