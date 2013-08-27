<?php

require_once "/var/www/magento/app/Mage.php";
Mage::app();
    
    // Set indexing to manual before starting updates, otherwise it'll continually get slower as you update
$processes = Mage::getSingleton('index/indexer')->getProcessesCollection();
$processes->walk('setMode', array(Mage_Index_Model_Process::MODE_MANUAL));
$processes->walk('save');

// Get Collection
$collection = Mage::getModel('catalog/product')->getCollection()
    ->addAttributeToSelect('sku')
    ->addAttributeToSelect('manufacturer')
    ->addFieldToFilter(array(array('attribute'=>'manufacturer','eq'=>'Intel')));


function productUpdateCallback(){
    //$product = Mage::getModel('catalog/product');

    //$product->setData($args['row']);

    //$productId ='167';

    $sku = 'yourSku';

    // Updates a single attribute, much faster than calling a full product save
    Mage::getSingleton('catalog/product_action')
        ->updateAttributes(array(167), array('sku' => $sku), 0);
}

// Walk through collection, for large collections this is much faster than using foreach
Mage::getSingleton('core/resource_iterator')->walk($collection->getSelect(), array('productUpdateCallback'));


// Reindex all
$processes->walk('reindexAll');
// Set indexing back to realtime, if you have it set to manual normally you can comment this line out
$processes->walk('setMode', array(Mage_Index_Model_Process::MODE_REAL_TIME));
$processes->walk('save');
