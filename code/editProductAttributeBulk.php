<?php

require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);
Mage::app('default');
$timer = new Benchmark_Timer();
$timer->start();
$collection = Mage::getModel('catalog/product')->getCollection()
	->addAttributeToSelect('color')	
	//$collection->addAttributeToSelect('sku');
	//$collection->addAttributeToSelect('orig_price');
	->addFieldToFilter(array(array('attribute'=>'color','neq'=>''),));
	//print_r($collection);
	$count = null;
	foreach ($collection as $products){
		$count++;	
		$p_id = $products->getId();
		$product = Mage::getModel('catalog/product')->load($p_id);
		setOrAddOptionAttribute($product, 'color', 'My Color',$p_id);
	}
$timer->stop();
$timer->display();
echo $count." records updated. \n".memory_get_peak_usage() / 1024;
echo "\n";
function setOrAddOptionAttribute($product, $arg_attribute, $arg_value, $p_id) {
			
			$attribute_model = Mage::getModel('eav/entity_attribute');
			$attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');
			$attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
			//echo $attribute_code."\n";
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
			try{
				$product->setData($arg_attribute, $m_id)->getResource()->saveAttribute($product,$arg_attribute);
				echo $p_id." Updated Successfully \n";
			} catch(Exception $e){ echo $e;}
	}
