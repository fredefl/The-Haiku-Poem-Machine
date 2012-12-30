<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?><?php echo $css_url; ?>style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?><?php echo $css_url; ?>styles.css">
    <link rel="stylesheet" href="<?php echo $css_url; ?>chosen.css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/smoothness/jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo $base_url; ?><?php echo $css_url; ?>add.css">
</head>
<body>
    <div style=" position:absolute; left:60px; top:80px; border:5px; border-style:outset; height:360px; width:180px; border-bottom-color:#000; margin:0px 0px 5px 5px;">
        <form action="<?php echo $base_url; ?>add/POST" method="POST">
            <label for="Field1">Sætning 1/Sentence 1</label>
            <br>
            <input type="text" name="Field1" id="Field1">
            <br>
            <br>
            <label for="Field2">Sætning 2/Sætning 2</label>
            <br>
            <input type="text" name="Field2" id="Field2">
            <br>
            <br>
            <label for="Field3">Sætning 3/Sentence 3</label>
            <br>
            <input type="text" name="Field3" id="Field3">
            <br>
            <br>
            <label for="Creator">Forfatter/Author</label>
            <br>
            <input type="text" name="Creator" id="Creator">
            <br>
            <br>
            <input type="hidden" value="Llama" name="Pass">
            <label for="Lang">Vælg Land</label>
            <br>
            	<?php echo $languages; ?>
            <br>
            <br>
            <input type="submit" id="submit" style="margin-left:auto; width:80px; left:45px; position:absolute; margin-right;">
        </form>
	<div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script src="https://js.pusherapp.com/1.9/pusher.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?><?php echo $js_url; ?>script.js"></script>	
    <script src="<?php echo $base_url; ?><?php echo $js_url;?>standard.js"></script> 
    <script src="<?php echo $base_url; ?><?php echo $js_url;?>view.js"></script>  
	<script src="<?php echo $base_url; ?><?php echo $js_url;?>chosen.jquery.min.js"></script>  
    
</body>
</html>