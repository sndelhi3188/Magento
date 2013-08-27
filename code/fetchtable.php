<?php
//define('MAGENTO', realpath(dirname(__FILE__).'/../'));
require_once '/var/www/india.bestylish.com/web/app/Mage.php';
Mage::app();

//define('NAVISION_LIB', Mage::getBaseDir() . '/lib/');
//include_once(NAVISION_LIB . "Navision/navisionClass.php");
$orderId = 100412323;
$connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        $rmaorders = $connection->fetchAll("SELECT entity_id FROM sales_flat_order WHERE increment_id='".$orderId."' ");
        foreach ($rmaorders as $rmaVal) {
//                 $newRma = $rmaVal['entity_id'];
		print_r($rmaVal);
        }


