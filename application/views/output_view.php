<!Doctype html>
<html>
<head>
<link rel="stylesheet" href="<?php echo $css_url; ?>output.css">
<link rel="stylesheet" href="<?php echo $css_url; ?>standard.css">
<link rel="stylesheet" href="<?php echo $css_url; ?>standard.css" type="text/css" media="print" />
<link rel="stylesheet" href="<?php echo $css_url; ?>view.css" type="text/css" media="print" />
<link rel="stylesheet" href="<?php echo $css_url; ?>chosen.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/smoothness/jquery-ui.css"/>
<title><?php echo $page_title; ?></title>
<!--[if lt IE 9]>
      <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<style type="text/css">
@font-face {
    font-family: "Bonzai";
    src: url(<?php echo $base_url; ?><?php echo $fonts_url;?>bonzai.ttf);
}

.text{
	font-family: "Bonzai";
    font-size: 250%;	
}
</style>
<!--[if lte IE 8]>
    <style type="text/css">
    @font-face {
        font-family: bonzai;
        src:url(<?php echo $base_url; ?><?php echo $fonts_url;?>bonzai.eot);
    }
    
    .text{
		font-family:bonzai;
    	font-size: 250%;	
	}
     </style>
<![endif]-->
<style type="text/css" media="print">
@font-face {
    font-family: "Bonzai";
    src: url(<?php echo $base_url; ?><?php echo $fonts_url;?>bonzai.ttf);
}

.text{
	font-family: "Bonzai";
    font-size: 250%;	
}
</style>
<!--[if lte IE 8]>
    <style type="text/css" media="print">
    @font-face {
        font-family: bonzai;
        src:url(<?php echo $base_url; ?><?php echo $fonts_url;?>bonzai.eot);
    }
    
    .text{
		font-family:bonzai;
    	font-size: 250%;	
	}
     </style>
<![endif]-->
</head>
<body>
<input id="base_url" value="<?php echo $base_url; ?>" type="hidden">
    <div id="box">            
        <div class="text" style="font-family:bonzai; font-size: 250%;">
            <p id="title"><?php echo $title; ?></p>
            <?php echo $Sentence1; ?><br>
            <?php echo $Sentence2; ?><br>
            <?php echo $Sentence3; ?><br>
        </div>         
    </div>
    <div id="share">
        <button id="All"><?php echo $all; ?></button>
        <button id="Print"><?php echo $print; ?></button>
        <button id="Share"><?php echo $share; ?></button>
        <button id="Id">Id</button>
        <button id="Return"><?php echo $return; ?></button>
    </div>
    <div id="copyright">
        <a style="color:#70777a;" href="https://illution.dk">Copyright &copy; Illution 2011</a>
    </div> 
    
    <div id="idDialog" title="<?php echo $id_dialog; ?>" style="display:none; overflow:hidden">
     	<label id="iddialogLabel" for="dialogId" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $id_label; ?>:</label>
        <input type="text" id="dialogId" style="width:260px">
        <button id="idDialogClose" style="width:265px;"><?php echo $search; ?></button>
    </div>
    
   	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script src="<?php echo $js_url;?>standard.js"></script>  
    <script src="<?php echo $js_url;?>output.js"></script>  
     
</body>
</html>