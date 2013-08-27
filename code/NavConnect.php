<?php
define('MAGENTO', realpath(dirname(__FILE__).'/../'));
require_once MAGENTO . '/app/Mage.php';
Mage::app();

define('NAVISION_LIB', Mage::getBaseDir() . '/lib/');
include_once (NAVISION_LIB . "Navision/navisionClass.php");

// API Interface
define('USERPWD', 'Smile\navsuperuser:erppass@217bestylish');
$baseURL = 'http://14.141.59.25:7047/DynamicsNAV/WS/Smile%20Sales-Live/';
$salesOrder = 'Codeunit/CustomersLogin';
$user = "CUST-0001";
$pass = "68634";
function checkCustomer($user, $pass ) {
    global $baseURL, $salesOrder;
    stream_wrapper_unregister('http');
    stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");

    $client = new NTLMSoapClient($baseURL . $salesOrder);
    //$params['itemCode'] = $sku;
    $param['customerCode'] =$user;
    $param['pwd'] =$pass;
    try {
        $result = $client->GetCustomers($param);
        print_r( $result->return_value );
    } catch (exception $e) {
        print_r($e->getMessage());
        //return 0;
    }
}

checkCustomer($user, $pass);
