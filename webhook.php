<?php

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'r8P>0(GxC\pzm8VAoj9g4YNBjh_NIh@dGGqjxABT8+6i>(bX#yn5Bt[r5wc7Gvax') {
  echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];


welcome();




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


// //API Url
// $url = 'https://graph.facebook.com/v2.6/327850837269511/messages?access_token=CAAPkT5ZApWjMBALQ0dkk5wDeCuExe8MJ8jsJDN9MoEsDaG7r6mZCVJ77y2EXm5ugwmRi2ry81IF6nwreUQ24hQEqkzlTFs96zt8pj0AizihrYFZC065WUzS2vb6rjMlJjxjD5WMynOgKrRsNultasc4yInZASZBP6UFC7Y4rO7zdFz1j6FCgYtWcrf918nCQcOwDIXZAzzzgZDZD';

// //Initiate cURL.
// $ch = curl_init($url);

// //The JSON data.
// $jsonData = '{
//     "recipient":{
//         "id":"'.$sender.'"
//     }, 
//     "message":{
//         "text":"Hey Lee!"
//     }
// }';

// //Encode the array into JSON.
// $jsonDataEncoded = $jsonData;

// //Tell cURL that we want to send a POST request.
// curl_setopt($ch, CURLOPT_POST, 1);

// //Attach our encoded JSON string to the POST fields.
// curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

// //Set the content type to application/json
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// //Execute the request
// if(!empty($input['entry'][0]['messaging'][0]['message'])){
// $result = curl_exec($ch);
// }


?>