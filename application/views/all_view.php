<!Doctype html>
<html>
<head>
<link rel="stylesheet" href="<?php echo $css_url; ?>view.css">
<link rel="stylesheet" href="<?php echo $css_url; ?>standard.css">
<link rel="stylesheet" href="<?php echo $css_url; ?>standard.css" type="text/css" media="print" />
<link rel="stylesheet" href="<?php echo $css_url; ?>view.css" type="text/css" media="print" />
<link rel="stylesheet" href="<?php echo $css_url; ?>chosen.css" />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/smoothness/jquery-ui.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <input type="hidden" id="current_time" value="<?php echo $current_time ?>">
	<?php echo $data; ?>
    
   	<div id="share">
        <button id="Print"><?php echo $print; ?></button>
        <button id="Creator"><?php echo $creator; ?></button>
        <button id="Time"><?php echo $time; ?></button>
        <button id="Id">Id</button>
        <button id="Return"><?php echo $return; ?></button>
    </div>
    <div id="copyright">
        <a style="color:#70777a;" href="https://illution.dk">Copyright &copy; Illution 2011</a>
    </div> 
    
     <div id="timeDialog" title="<?php echo $text_data['TimeInterval']; ?>" style="display:none; overflow:hidden">
   	  <label id="timeDialogLabel" for="Name" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $text_data['TimeDataText']; ?></label><br>
     	<input type="time" id="TimeInput">&nbsp;<select id="dialogSelect">
			<option value="Seconds"><?php echo $text_data["Sec"]; ?></option>
            <option value="Minutes" selected><?php echo $text_data["Minute"]; ?></option>
            <option value="Hours" ><?php echo $text_data["Hours"]; ?></option>
            <option value="Days" ><?php echo $text_data["Days"]; ?></option>
            <option value="Week" ><?php echo $text_data["Week"]; ?></option>
            <option value="Months" ><?php echo $text_data["Months"]; ?></option>
            <option value="Years" ><?php echo $text_data["Years"]; ?></option>            
        </select>
        <button id="timeDialogClose"><?php echo $text_data["Search"]; ?></button>
     </div>
     
     <div id="nameDialog" title="<?php echo $text_data['NameData']; ?>" style="display:none; overflow:hidden">
    	<label id="nameDialogLabel" for="Name" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $text_data['NameDataText']; ?></label>
     	<input type="text" id="Name">
        <button id="nameDialogClose"><?php echo $text_data["Search"]; ?></button>
     </div>
     
    <div id="idDialog" title="<?php echo $id_dialog; ?>" style="display:none; overflow:hidden">
     	<label id="iddialogLabel" for="dialogId" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $id_label; ?>:</label>
        <input type="text" id="dialogId" style="width:260px">
        <button id="idDialogClose" style="width:265px;"><?php echo $text_data["Search"]; ?></button>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script src="<?php echo $js_url;?>standard.js"></script> 
    <script src="<?php echo $js_url;?>view.js"></script>  
</body>
</html>