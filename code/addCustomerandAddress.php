<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);
Mage::app('default');

$customer = Mage::getModel('customer/customer');
//$customer  = new Mage_Customer_Model_Customer();
$password = '123456';
$email = 'ale@yahoomail.com';
$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
$customer->loadByEmail($email);
//Zend_Debug::dump($customer->debug()); exit;
if(!$customer->getId()) {
    $customer->setEmail($email);
    $customer->setFirstname('Johnny');
    $customer->setLastname('Doels');
    $customer->setPassword($password);
}
try {
    $customer->save();
    $customer->setConfirmation(null);
    $customer->save();
    //Make a "login" of new customer
    Mage::getSingleton('customer/session')->loginById($customer->getId());
}
catch (Exception $ex) {
    print_r($ex->getMessage());
}

$_custom_address = array (
    'firstname' => 'Branko',
    'lastname' => 'Ajzele',
    'street' => array (
        '0' => 'Sample address part1',
        '1' => 'Sample address part2',
    ),
    'city' => 'Osijek',
    'region_id' => '515',
    //'region' => '',
    'postcode' => '31000',
    'country_id' => 'IN', /* Croatia */
    'telephone' => '0038531555444',
);
$customAddress = Mage::getModel('customer/address');
//$customAddress = new Mage_Customer_Model_Address();
$customAddress->setData($_custom_address)
            ->setCustomerId($customer->getId())
            ->setIsDefaultBilling('1')
            //->setIsDefaultShipping('1')
            ->setSaveInAddressBook('1');
try {
    $customAddress->save();
}
catch (Exception $ex) {
    print_r($ex->getMessage());
}
