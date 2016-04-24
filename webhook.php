<?php

/* GLOBAL */
$p_token = "CAAPkT5ZApWjMBABEkw1ZCI8C8OuF0vZBTKsyRyWGkfR7p5QzeCZBtcJWYlLjdgZCSFl0mlBs1vmQT1zZBcxROPCf2H0CaB4yCNMyMrDuy81I4eVEb7B1EdJDoHQFeiDQGnllbaRZCZBtJAB7bih3W0twsNjc9IOl20nFo0YnHAxDIW1ezu3ZAIV6XdrfXQnuYHZBoDNpUKiIbOfwZDZD";

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'r8P>0(GxC\pzm8VAoj9g4YNBjh_NIh@dGGqjxABT8+6i>(bX#yn5Bt[r5wc7Gvax') {
  echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);

// Get Guest Common Info
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];

// Ghi logs
file_put_contents('logs.txt', date("dd/MM/yyyy hh:mm:ss")." - ".$sender." - ".$message."\n", FILE_APPEND);

// Init Facebook Bot...
subscribe();

//echo reply("Xin chào bạn");

function subscribe()
{
	$url = "https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=".$p_token;

	echo sendRequest($url, '');

	// $ch = curl_init($url);
	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, '');
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// $data = curl_exec($ch);
	// echo $data;
	//var_dump(json_decode($result, true));
}

function sendRequest($url, $data = '')
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

/*
function welcome(){
	$url = "https://graph.facebook.com/v2.6/327850837269511/thread_settings?access_token=".$p_token;

	$jsonData = '{
	    "recipient":{
	        "id":"'.$sender.'"
	    }, 
	    "message":{
	        "text":"Xin chào bạn!"
	    }
	}';

	sendRequest($url, $jsonData);
}

function getAnswer()
{
	$ans = "";
}

function getGuestInfo($uid)
{
	$url = "https://graph.facebook.com/v2.6/" + $uid + "?fields=first_name,last_name,profile_pic&access_token=".$p_token;

}

function reply($mes)
{
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$p_token;

	//The JSON data.
	$jsonData = '{
	    "recipient":{
	        "id":"'.$sender.'"
	    }, 
	    "message":{
	        "text":"'.$mes.'"
	    }
	}';

	return sendRequest($url, $jsonData);
}
*/

?>