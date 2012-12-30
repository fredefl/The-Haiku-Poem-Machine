<?php
//Start the session again so we can access the username and userid
session_start();

//include the pusher publisher library
include_once 'Pusher.php';

//These values are automatically POSTed by the Pusher client library
$socket_id = $_POST['socket_id'];
$channel_name = $_POST['channel_name'];

//You should put code here that makes sure this person has access to this channel
/*
if( $user->hasAccessTo($channel_name) == false ) {
	header('', true, 403);
	echo( "Not authorized" );
	exit();
}
*/

$pusher = new Pusher(
	'9b245d36fea0d2611317', //APP KEY
	'fa94913f60675f98df21', //APP SECRET
	'9949' //APP ID
);

//Any data you want to send about the person who is subscribing
$presence_data = array(
);

echo $pusher->presence_auth(
	$channel_name, //the name of the channel the user is subscribing to 
	$socket_id, //the socket id received from the Pusher client library
	$_SESSION['userid'],  //a UNIQUE USER ID which identifies the user - for now, we'll just use the time() (from start_session.php) since we don't have an existing user database
	$presence_data //the data about the person
);
exit();
?>