<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');

$order = Mage::getModel('sales/order')->getCollection()
	//->addFieldToFilter('customer_lastname','like' =>'nayak')
	->addFieldToFilter('customer_email',array('like' =>'sndelhi3188@gmail.com'));
	//->addFieldToFilter('created_at','2013-')
	//->addFieldToFilter(array('customer_firstname','customer_lastname'),array(array('like'=>'%udh%'), array('like'=>'%kl%')))
	//->addFieldToFilter('created_at',array('from'=>'2013-05-07 00:00:00','to' =>'2013-07-19 00:00:00'))
	//->addFieldToFilter('status', array('nin' => array('canceled','complete')));
$count = null;
foreach($order as $orderid){
	$count++;
	print_r($orderid->getincrementId());
	echo "\n";
}
echo $count."\n";
