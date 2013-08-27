<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors',1);
umask(0);

Mage::app('default');
$orderStatus = $argv[1];
$orders = Mage::getModel('sales/order')->getCollection()
	->addFieldToFilter('status',$orderStatus)
//	->addAttributeToSelect('customer_email')
//	->addAttrbuteToSelect('increment_id')
	;
foreach($orders as $order){
	$email = $order->getCustomerEmail();
	$orderId = $order->getIncrementId();
	echo $orderId."\t".$email."\n";
}
