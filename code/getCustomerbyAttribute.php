<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');

$customers  = Mage::getModel('customer/customer')->getCollection()
        	         ->addAttributeToSelect('email')
                	 ->addFieldToFilter('is_dealer_agent',array('nin'=>array('0')))->getData();
foreach($customers as $customer){
	echo $customer["email"]."\n";
}

