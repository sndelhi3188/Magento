<?php

require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');
$_menu;
$this->_menu = new Varien_Data_Tree_Node(array(), 'root', new Varien_Data_Tree());
$hello = Mage::dispatchEvent('page_block_html_topmenu_gethtml_before', array(
            'menu' => $this->_menu
        ));
print_r($hello);
/*$productId = 167; 
$attributeName = 'color';
 
$product = Mage::getModel('catalog/product')->load($productId);

$attributes = $product->getAttributes();
 
$attributeValue = 'Hello';     
if(array_key_exists($attributeName , $attributes)){
    $attributesobj = $attributes["{$attributeName}"];
    $attributeValue = $attributesobj->getFrontend()->getValue($product);
}
echo $attributeValue."\n";*/

