<?php
$heading = str_replace("<p>","",str_replace("</p>","",$heading));
$message = str_replace("<p>","",str_replace("</p>","",$message));
echo "<h3>".$heading."</h3>";
echo "<h3>".$message."</h3>";
die();
?>