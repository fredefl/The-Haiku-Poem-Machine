<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo $css_url; ?>style.css">
    <link rel="stylesheet" href="<?php echo $css_url; ?>styles.css">
    <link rel="stylesheet" href="http://cdn.illution.dk/CSS/chosen.css" />
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/smoothness/jquery-ui.css"/>
    <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style type="text/css">
	@font-face {
		font-family: "Bonzai";
		src: url(http://illution.dk/Haiku/<?php echo $fonts_url;?>bonzai.ttf);
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
			src:url(http://illution.dk/Haiku/<?php echo $fonts_url;?>bonzai.eot);
		}
		
		.text{
			font-family:bonzai;
			font-size: 250%;	
		}
		 </style>
	<![endif]-->
</head>
<body style="display:none;"> 
	<input id="base_url" value="<?php echo $base_url; ?>" type="hidden">
    <input type="hidden" id="current_time" value="<?php echo $current_time ?>">

	<form action="http://illution.dk/Haiku/output" method="post" id="submitForm">
        <input type="hidden" id="sentence1Form" name="sentence1">
        <input type="hidden" id="sentence2Form" name="sentence2">
        <input type="hidden" id="sentence3Form" name="sentence3">
        <input type="hidden" id="langForm" name="lang" value="<?php echo $langcode; ?>">
        <input type="hidden" id="creatorForm" name="creator" value="Dumbo Klodshans Tommelfinger">
    </form>
    <div id="Container">
        <ul id="questions">
        	<li>
            	<p id="title"></p>
                <button id="submitButton" style="width:300px;margin-right:15px;display:none">Send</button>
            </li>
        </ul>
    </div>
    <div id="poemShowcaseContainer">
    	<div id="poemShowcase">
    	</div>
    </div>
    
    <div id="shareContainer">
    	<div id="share">
      	 	<button id="All"><?php echo $all; ?></button>
            <button id="Creator"><?php echo $creator; ?></button>
            <button id="Time"><?php echo $time; ?></button>
            <button id="Id">Id</button>
        </div>
    </div>
    
    <div id="copyrightContainer">
        <div id="copyright">
            <a style="color:#70777a;" href="http://illution.dk">Copyright &copy; Illution 2011</a>
        </div>
    </div>
    
    <div id="dialog" title="<?php echo $text_data['WriteASentece']; ?>" style="display:none; overflow:hidden">
    	<label id="dialogLabel" data-translated="<?php echo $text_data['Syllables']; ?>" for="dialogSentence" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $text_data['FiveSyllables']; ?></label>
        <input type="text" id="dialogSentence" style="width:240px;">
        <img id="dialogValidationIcon" src="assets/images/validationError.png"/>
        <input type="hidden" id="dialogSentenceNumber" style="width:100%;">
        <button style="width:100%;margin-top:10px;" id="dialogSaveButton"><?php echo $text_data['Save']; ?></button>
        <div id="syllables"></div>
    </div>
    
    <div id="saveDialog" title="<?php echo $text_data['Name']; ?>" style="display:none; overflow:hidden">
    	<input type="text" id="saveDialogName" style="width:98%;margin-top:5px;">
    	<button style="width:100%;margin-top:15px;" id="saveDialogSaveButton"><?php echo $text_data['Save']; ?></button>
    </div>
    
    <div id="nameDialog" title="<?php echo $text_data['NameData']; ?>" style="display:none; overflow:hidden">
    	<label id="nameDialogLabel" for="Name" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $text_data['NameDataText']; ?></label>
     	<input type="text" id="Name">
        <button id="nameDialogClose"><?php echo $text_data['Search']; ?></button>
     </div>
     
    <div id="idDialog" title="<?php echo $id_dialog; ?>" style="display:none; overflow:hidden">
     	<label id="iddialogLabel" for="dialogId" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $id_label; ?>:</label>
        <input type="text" id="dialogId" style="width:260px">
        <button id="idDialogClose" style="width:265px;"><?php echo $text_data['Search']; ?></button>
    </div>
    
    <div id="timeDialog" title="<?php echo $text_data['TimeInterval']; ?>" style="display:none; overflow:hidden">
   	  <label id="timeDialogLabel" for="Name" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $text_data['TimeDataText']; ?>
      </label><br>
     	<input type="time" id="TimeInput">&nbsp;<select id="dialogSelect">
			<option value="Seconds"><?php echo $text_data["Sec"]; ?></option>
            <option value="Minutes" selected><?php echo $text_data["Minute"]; ?></option>
            <option value="Hours" ><?php echo $text_data["Hours"]; ?></option>
            <option value="Days" ><?php echo $text_data["Days"]; ?></option>
            <option value="Week" ><?php echo $text_data["Week"]; ?></option>
            <option value="Months" ><?php echo $text_data["Months"]; ?></option>
            <option value="Years" ><?php echo $text_data["Years"]; ?></option>            
        </select>
        <button id="timeDialogClose"><?php echo $text_data['Search']; ?></button>
     </div>
   	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script src="<?php echo $js_url;?>pusher.min.js"></script>
	<script src="<?php echo $js_url; ?>script.js"></script>	
    <script src="<?php echo $js_url;?>standard.js"></script> 
    <script src="<?php echo $js_url;?>view.js"></script>  
	<script src="http://cdn.illution.dk/JS/chosen.jquery.min.js"></script>        
</body>
</html>
