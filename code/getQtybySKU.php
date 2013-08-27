<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');

$sku = Mage::getModel('catalog/product')->getCollection()
	//->addFieldToFilter('customer_lastname','like' =>'nayak')
	//->addFieldToFilter('created_at','2013-'
	->addFieldToFilter(array('sku'),array(array('like'=>'n2610')));
//	->addFieldToFilter('status', array('nin' => array('canceled','complete')));
$count = null;
foreach($sku as $skus){
	$count++;
	print_r($skus->getincrementId());
	echo "\n";
}
echo $count."\n";
