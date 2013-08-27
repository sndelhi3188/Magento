<?php

try
{
	$magento_webserver = "http://bestylish.dev/";
    $client  = new SoapClient($magento_webserver."/api/v2_soap?wsdl=1");
    $sessionId  = $client->login(sudheer_nayak,nayak786n);
    echo "Soap login complete! <br/>";
    echo "======================== <br/>";
	//echo "hello";
	//$products = $proxy->call($sessionId, 'sales_order.list');
	//print_r($products);
	$param = array('filter' => array(
		array('key' => 'status', 'value' => 'pending'),
		array('key' => 'customer_is_guest', 'value' => '0')
	));
	$result = $client->salesOrderList($sessionId,$param);
	print_r($result);
	//foreach($result[0] as $key => $value){
	//	echo "$key => $value"."</br>";
	//}
}
catch (SoapFault $fault)
{
    die("\n\n SOAP Fault: (fault code: {$fault->faultcode},
    fault string: {$fault->faultstring}) <br/>");
}
?>
