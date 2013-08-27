<?php

require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');
$productId = 167; 
$product = Mage::getModel('catalog/product')->load($productId);
//$product->setData('color','color')->getResource()->saveAttribute($product, 'color');

$product->setData(array('sku','red')); $product->getResource()->saveAttribute($product, 'sku');
//$product->updateAttributes(array('color' => 'color'));
