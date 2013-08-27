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
	$filter = array('complex_filter' => array( array ( 'key' => 'group_id','value' => array ( 'key' => 'in','value' => '0,1' )))); 
	$result = $client->customerCustomerList($sessionId,$filter);
			
	print_r($result);
}
catch (SoapFault $fault)
{
 	die("\n\n SOAP Fault: (fault code: {$fault->faultcode},
	fault string: {$fault->faultstring}) <br/>");
}
?>
