<?php
require_once('AfricasTalkingGateway.php');
//Specify your credentials
$username = "jani";
$apiKey   = "d46192b5e6c1bdf6e24ae3760f5d49cde42e8b09d53f01fc929eec205996f5ce";

//Concept 
/*
	- query checkout DB which has numbers and status
	-launch checkout.

*/

//5. Check the level of the user from the DB and retain default level if none is found for this session
$sql = "select * from checkout where status = 'pending' ";
$statusQuery = $db->query($sql);

while($results = $statusQuery->fetch_assoc()){
	// Send a request to the gateway to effect checkout. This will happen every 5 minutes?
	echo $results['phoneNumber'];
	echo $results['amount'];	

	$gateway = new AfricasTalkingGateway($username, $apiKey, "sandbox");

	$productName  ="Nerd Payments"; 
	$phoneNumber  = $results['phoneNumber'];;
	$currencyCode = "KES";
	$amount       = $results['amount'];
	$metadata     = array("sacco"=>"Nerds","productId"=>"321"

	try {
	  $transactionId = $gateway->initiateMobilePaymentCheckout($productName, $phoneNumber,$currencyCode, $amount, $metadata);
	  echo "The id here is ".$transactionId;
	}
	catch(AfricasTalkingGatewayException $e){
	  echo "Received error response: ".$e->getMessage();
	}

}
		

?>