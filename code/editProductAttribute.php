<?php

require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');
$productId = 167; 
//$attributeName = 'color';
 
$product = Mage::getModel('catalog/product')->load($productId);
//print_r($product);
//$product->setData($arg_attribute, $arg_value);
function setOrAddOptionAttribute($product, $arg_attribute, $arg_value) {
	
	$attribute_model = Mage::getModel('eav/entity_attribute');
	$attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

	$attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
	echo $attribute_code."\n";
	$attribute = $attribute_model->load($attribute_code);
	//print_r($attribute);
	$attribute_options_model->setAttribute($attribute);
	$options = $attribute_options_model->getAllOptions(false);
	//print_r($options);
	// determine if this option exists
	$value_exists = false;
	foreach($options as $option) {
		if ($option['label'] == $arg_value) {
			$value_exists = true;
			break;
		}
	}

	// if this option does not exist, add it.
	if (!$value_exists) {
		$attribute->setData('option', array(
			'value' => array(
				'option' => array($arg_value,$arg_value)
			)
		));
		$attribute->save();
	}
	$m_id = $product->getResource()->getAttribute($arg_attribute)->getSource()->getOptionId($arg_value);
	$product->setData($arg_attribute, $m_id)->getResource()->saveAttribute($product,$arg_attribute);
}
setOrAddOptionAttribute($product, 'color', 'voilet');
