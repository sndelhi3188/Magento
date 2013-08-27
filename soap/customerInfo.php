<?php

try
{
	$magento_webserver = "http://bestylish.dev/";
	$client  = new SoapClient($magento_webserver."/api/v2_soap?wsdl=1");
    	$usr ="sudheer_nayak";
	$pass ="nayak786n";
	$sessionId  = $client->login($usr,$pass);
	echo "Soap login complete! <br/>";
	echo "======================== <br/>";
	//print_r($products);
	$result = $client->customerCustomerInfo($sessionId,1);
	//print_r($result);
	//$xml = objectToArray($result);
	print_r($result->customer_id);
	print_r( get_class_vars( get_class($result)) );
}
catch (SoapFault $fault)
{
 	die("\n\n SOAP Fault: (fault code: {$fault->faultcode},
	fault string: {$fault->faultstring}) <br/>");
}
?>
