<?php

require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);

Mage::app('default');
/* for Attribute to filter */
$collection = Mage::getModel('catalog/product')->getCollection()
	//$collection->addAttributeToSelect('sku');
	//$collection->addAttributeToSelect('orig_price');
	->addAttributeToFilter('color', array('neq' => ''))
	->addAttributeToSelect('*');
	//print_r($collection);
	foreach ($collection as $product){
		echo $product->getId()."\n";
	}


/* for field to filter
 * Mage::getModel('catalog/product')->getCollection()
    ->addFieldToFilter(
        array(
            array(
                'attribute' => 'manufacturer',
                'null' => 'null' //this value don't matter
            )    
         )
     )
    ->addAttributeToSelect('*');
*/
