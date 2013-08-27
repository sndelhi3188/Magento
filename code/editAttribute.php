<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');

function addAttributeOption($attribute_code, $attributes_value) {
    $attribute_model = Mage::getModel('eav/entity_attribute');
    $attribute_options_model= Mage::getModel('eav/entity_attribute_source_table') ;
   
    $attribute_code = $attribute_model->getIdByCode('catalog_product', $attribute_code);
    $attribute = $attribute_model->load($attribute_code);
   
    $attribute_table = $attribute_options_model->setAttribute($attribute);
    $options = $attribute_options_model->getAllOptions(false);
    
    foreach($attributes_value as $attribute_value){
    $value['option'] = array($attribute_value,$attribute_value);
    $result = array('value' => $value);
    $attribute->setData('option',$result);
    $attribute->save();
    echo $attribute_value."added sucessfully. \n";
	}
}
$arrays = array('red1','red1','red2');
addAttributeOption('color', $arrays);

?>
