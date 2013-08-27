<?php

require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');
//$productId = 167; 

Mage::app ()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$productCollection = Mage::getModel('catalog/product')->getCollection();

foreach($productCollection as $_product) 
{
    echo "\n".'updating '.$_product->getSku()."...\n";
    $product = Mage::getModel('catalog/product')->load($_product->getEntityId());
    $product->setData('add_ten_pence', 1)->getResource()->saveAttribute($product, 'add_ten_pence');
}
