<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');
$attributes = Mage::getSingleton('eav/config')
->getEntityType(Mage_Catalog_Model_Product::ENTITY)->getAttributeCollection();
//$result = array();
foreach($attributes as $attribute){
print_r($attribute['attribute_code']);
echo "\n";
}

