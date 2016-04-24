<?php

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'r8P>0(GxC\pzm8VAoj9g4YNBjh_NIh@dGGqjxABT8+6i>(bX#yn5Bt[r5wc7Gvax') {
  echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];

file_put_contents('logs.txt', date("dd/MM/yyyy hh:mm:ss")." - ".$sender." - ".$message."\n", FILE_APPEND);

subscribe();

function subscribe()
{
	$url = "https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=CAAPkT5ZApWjMBABEkw1ZCI8C8OuF0vZBTKsyRyWGkfR7p5QzeCZBtcJWYlLjdgZCSFl0mlBs1vmQT1zZBcxROPCf2H0CaB4yCNMyMrDuy81I4eVEb7B1EdJDoHQFeiDQGnllbaRZCZBtJAB7bih3W0twsNjc9IOl20nFo0YnHAxDIW1ezu3ZAIV6XdrfXQnuYHZBoDNpUKiIbOfwZDZD";

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	echo $data;
	//var_dump(json_decode($result, true));
}

function welcome(){
	$url = "https://graph.facebook.com/v2.6/327850837269511/thread_settings?access_token=CAAPkT5ZApWjMBALQ0dkk5wDeCuExe8MJ8jsJDN9MoEsDaG7r6mZCVJ77y2EXm5ugwmRi2ry81IF6nwreUQ24hQEqkzlTFs96zt8pj0AizihrYFZC065WUzS2vb6rjMlJjxjD5WMynOgKrRsNultasc4yInZASZBP6UFC7Y4rO7zdFz1j6FCgYtWcrf918nCQcOwDIXZAzzzgZDZD";

	$jsonData = '{
	    "recipient":{
	        "id":"'.$sender.'"
	    }, 
	    "message":{
	        "text":"Xin chào bạn!"
	    }
	}';

	$jsonDataEncoded = $jsonData;

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	return curl_exec($ch);
}


//API Url
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token=CAAPkT5ZApWjMBABEkw1ZCI8C8OuF0vZBTKsyRyWGkfR7p5QzeCZBtcJWYlLjdgZCSFl0mlBs1vmQT1zZBcxROPCf2H0CaB4yCNMyMrDuy81I4eVEb7B1EdJDoHQFeiDQGnllbaRZCZBtJAB7bih3W0twsNjc9IOl20nFo0YnHAxDIW1ezu3ZAIV6XdrfXQnuYHZBoDNpUKiIbOfwZDZD';

//Initiate cURL.
$ch = curl_init($url);

//The JSON data.
$jsonData = '{
    "recipient":{
        "id":"'.$sender.'"
    }, 
    "message":{
        "text":"Hey Lee!"
    }
}';

//Encode the array into JSON.
$jsonDataEncoded = $jsonData;

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
if(!empty($input['entry'][0]['messaging'][0]['message'])){
$result = curl_exec($ch);
}


?>