<?php

try
{
	$magento_webserver = "http://bestylish.dev/";
    $client  = new SoapClient($magento_webserver."/api/v2_soap?wsdl=1");
    $user='sudheer_nayak';
    $pass = 'nayak786n';
    $sessionId  = $client->login($user,$pass);
    echo "Soap login complete! <br/>";
    echo "======================== <br/>";
	$product_exist=null;
	$product_exist = $client->catalogInventoryStockItemList($sessionId,array('tshirt_red'));
	if($product_exist==null or $product_exist ==""){
	echo "product not exists";
	}else{
	echo "product exist";
	var_dump($product_exist);
	}

}
catch (SoapFault $fault)
{
    die("\n\n SOAP Fault: (fault code: {$fault->faultcode},
    fault string: {$fault->faultstring}) <br/>");
}
?>
