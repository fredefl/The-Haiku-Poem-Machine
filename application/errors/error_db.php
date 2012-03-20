<?php
$heading = str_replace("<p>","",str_replace("</p>","",$heading));
$message = str_replace("<p>","",str_replace("</p>","",$message));
include 'http://illution.dk/Error.php?Heading='.urlencode($heading).'&Message='.urlencode($message).'&System=Haiku';
die();
?>