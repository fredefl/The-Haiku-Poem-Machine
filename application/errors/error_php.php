<?php
$severity = str_replace("<p>","",str_replace("</p>","",$severity));
$message = str_replace("<p>","",str_replace("</p>","",$message));
$filepath = str_replace("<p>","",str_replace("</p>","",$filepath));
$line = str_replace("<p>","",str_replace("</p>","",$line));
include 'http://illution.dk/Error.php?Severity='.urlencode($severity).'&Message='.urlencode($message).'&FilePath='.urlencode($filepath).'&Line='.urlencode($line).'&Method=PHP&System=Haiku';
die();
?>