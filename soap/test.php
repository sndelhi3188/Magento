<?php
$sku = 'tshirt_red';
        $products = Mage::getModel('catalog/product')->getCollection();
        $products->addFieldToFilter('sku',$sku);    
        foreach ($products as $product){
            if ($sku == $product->getSku()){
                echo 'The product is exist!';
            }
            else {
                echo 'There is no product with the SKU of '.$sku;
            }
        }
