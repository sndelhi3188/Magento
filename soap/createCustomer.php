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
	$result = $client->customerCustomerCreate($sessionId,
	array( 'email' => 'dheer4u@live.com',
	    'store_id' => 2,
	    'website_id' => 1, 
	    'firstname' => 'John',
	    'middlename' =>'Kumar', 
	    'lastname' => 'Doe',
	    'group_id' => 1,
	    'prefix' =>'Mr.', 
	    'suffix' => 'hello',
	    'taxvat'=> ''
	));
			
	print_r($result);
}
catch (SoapFault $fault)
{
 	die("\n\n SOAP Fault: (fault code: {$fault->faultcode},
	fault string: {$fault->faultstring}) <br/>");
}
?>
