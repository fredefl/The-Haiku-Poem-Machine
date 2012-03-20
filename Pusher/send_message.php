<?php
//Start the session again so we can access the username
session_start();

//include the pusher publisher library
include_once 'Pusher.php';

$pusher = new Pusher(
	'9b245d36fea0d2611317', //APP KEY
	'fa94913f60675f98df21', //APP SECRET
	'9949' //APP ID
);

//get the message posted by our ajax call
$message = $_POST['message'];

//trim and filter it
$message = trim(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

//trigger the 'new_message' event in our channel, 'presence-chat'
$pusher->trigger(
	'haiku-update-channel', //the channel
	'haiku-update', //the event
	array('message' => $message) //the data to send
);

//echo the success array for the ajax call
echo json_encode(array(
	'success' => true
));
exit();
?>