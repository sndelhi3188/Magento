<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);
Mage::app('default');
//print_r($argv);
$customer_email = $argv[1];  // email adress that will pass by the questionaire 

$customer = Mage::getModel('customer/customer');
//$customer->store = 1;
$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
$customer->loadByEmail($customer_email);
$_custom_address = array (
    'firstname' => 'Branko',
    'lastname' => 'Ajzele',
    'street' => array (
        '0' => 'Sample address part1',
        '1' => 'Sample address part2',
    ),
    'city' => 'Osijek',
    'region_id' => '156',
    'region' => 'Tripura',
    'postcode' => '31000',
    'country_id' => 'IN', /* Croatia */
    'telephone' => '3853155444',
);

$address = Mage::getModel('customer/address');
//$customAddress = new Mage_Customer_Model_Address();
	$address->addData($_custom_address);
	$customer->addAddress($address);
try {
    
	//$address->save();
	$customer->save();
}
catch (Exception $ex) {
	//Zend_Debug::dump($ex->getMessage());
	echo $ex;
}

