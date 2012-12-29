<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->lang->line("info_app_title");?> - <?php echo $this->lang->line("pages_home");?></title>
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>style.css">
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>styles.css">
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>chosen.css" />
    <link rel="stylesheet" href="<?php echo $jquery_ui_css_url;?>jquery-ui.css"/>
    <script type="text/javascript">
        var translations = {
            "alert" : "<?= $this->lang->line("errors_alert"); ?>",
            "missing_fields" : "<?= $this->lang->line("errors_fields_missing"); ?>",
            "no_sentences_match" : "<?= $this->lang->line("errors_no_sentences_matching"); ?>",
            "an_error_occured" : "<?= $this->lang->line("errors_an_error_occured"); ?>",
            "no_results_found" : "<?= $this->lang->line("home_chosen_no_result"); ?>"
        }
        var userLanguage = "<?php echo $this->ui_helper->language; ?>";
        var translation_vowels = <?php echo json_encode($this->lang->array_line("home_vowels_list")); ?>;
        var mode = "<?= $mode; ?>";
        var base_url = "<?= $base_url; ?>";

        <?php
            if (isset($collection)) {
                echo 'var collection = "'.$collection.'";';
            }
        ?>

    </script>
    <!--[if lt IE 9]>
          <script src="<?php echo $base_url.$html5_shiv_url; ?>"></script>
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
</head>
<body style="display:none;"> 
	<input id="base_url" value="<?php echo $base_url; ?>" type="hidden">
    <input type="hidden" id="current_time" value="<?php echo $current_time ?>">

    <div id="create" class="disabledPage">
        <div id="Container">
            <ul id="questions">
            	<li>
                	<p id="title"></p>

                    <select data-placeholder="<?= $this->lang->line("home_tag"); ?>" id="tag-select" multiple>
                        
                    </select>
                    
                    <img src="<?php echo $base_url; ?>assets/images/add.png" title="<?php echo $this->lang->line("home_add_tag"); ?>" style="margin-bottom:15px;margin-right:-20px;" id="addTag"></img>

                    <button id="submitButton" style="width:300px;margin-right:15px;display:none"><?php echo $this->lang->line("home_send"); ?></button>
                </li>
            </ul>
        </div>
        <div id="poemShowcaseContainer">
        	<div id="poemShowcase">
        	</div>
        </div>

        <div id="copyrightContainer">
            <div id="copyright">
                <a style="color:#70777a;" href="https://illution.dk"><?php echo $this->lang->line("info_copyright"); ?></a>
            </div>
        </div>
    </div>

    <div id="view" class="disabledPage">
        <div id="poemTemplate" style="display:none;">
            <div class="box" style="width:480px;">
                <p style="font-size:22px;" class="center-text"><strong>{title}</strong></p>
                <div class="text" style="margin-left:40px;">
                    {sentences}
                </div>
                <p><i> - {creator} : {date}</i></p>
            </div>
        </div>
    </div>

    <div id="saveDialog" title="<?php echo $this->lang->line("home_save_dialog_title"); ?>" style="display:none; overflow:hidden">
        <table>
            <tr><td><label for="saveDialogName" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $this->lang->line("home_name"); ?></label></td>
            <td><input type="text" id="saveDialogName"></tr></td>
            <tr><td><label for="saveDialogTitle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $this->lang->line("home_title"); ?></label></td>
            <td><input type="text" id="saveDialogTitle"></td></tr>
        </table>
        <button style="width:100%;margin-top:15px;" id="saveDialogSaveButton"><?php echo $this->lang->line("home_save"); ?></button>
    </div>

    <div id="addTagDialog" title="<?php echo $this->lang->line("home_add_tag"); ?>" style="display:none; overflow:hidden">
        <table>
            <tr><td><label for="tagInput" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $this->lang->line("home_tag"); ?></label></td>
            <td><input type="text" id="tagInput" style="width:127%;"></td></tr>
        </table>
        <button style="width:100%;margin-top:15px;" id="saveTagButton"><?php echo $this->lang->line("home_save"); ?></button>
    </div>

    <!--<div id="shareContainer">
        <div id="share">
            <button id="All"><?php echo $this->lang->line("home_all_poems"); ?></button>
            <button id="Creator"><?php echo $this->lang->line("home_creator"); ?></button>
            <button id="Time"><?php echo $this->lang->line("home_time"); ?></button>
            <button id="Id"><?php echo $this->lang->line("home_id"); ?></button>
        </div>
    </div>-->

    <div id="nameDialog" title="<?php echo $this->lang->line("home_desired_creator_name"); ?>" style="display:none; overflow:hidden">
        <label id="nameDialogLabel" for="Name" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $this->lang->line("home_desired_creator_name"); ?></label>
        <input type="text" id="Name">
        <button id="nameDialogClose"><?php echo $this->lang->line("home_search"); ?></button>
    </div>

    <div id="idDialog" title="<?php echo $this->lang->line("home_id_dialog_label"); ?>" style="display:none; overflow:hidden">
        <label id="iddialogLabel" for="dialogId" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $this->lang->line("home_id_dialog_label"); ?>:</label>
        <input type="text" id="dialogId" style="width:260px">
        <button id="idDialogClose" style="width:265px;"><?php echo $this->lang->line("home_search"); ?></button>
    </div>

    <div id="dialog" title="<?php echo $this->lang->line("home_write_sentence"); ?>" style="display:none; overflow:hidden">
        <label id="dialogLabel" data-translated="<?php echo $this->lang->line("home_syllabels"); ?>" for="dialogSentence" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $text_data['FiveSyllables']; ?></label>
        <input type="text" id="dialogSentence" style="width:240px;">
        <img id="dialogValidationIcon" src="<?= $base_url; ?>assets/images/validationError.png"/>
        <input type="hidden" id="dialogSentenceNumber" style="width:100%;">
        <button style="width:100%;margin-top:10px;" id="dialogSaveButton"><?php echo $this->lang->line("home_save"); ?></button>
        <div id="syllables"></div>
    </div>

    <div id="timeDialog" title="<?php echo $this->lang->line("home_select_time_range"); ?>" style="display:none; overflow:hidden">
   	  <label id="timeDialogLabel" for="Name" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;"><?php echo $this->lang->line("home_only_numbers"); ?>
      </label><br>
     	<input type="time" id="TimeInput">&nbsp;<select id="dialogSelect">
			<option value="Seconds"><?php echo $this->lang->line("home_seconds"); ?></option>
            <option value="Minutes" selected><?php echo $this->lang->line("home_minutes"); ?></option>
            <option value="Hours" ><?php echo $this->lang->line("home_hours"); ?></option>
            <option value="Days" ><?php echo $this->lang->line("home_days"); ?></option>
            <option value="Week" ><?php echo $this->lang->line("home_weeks"); ?></option>
            <option value="Months" ><?php echo $this->lang->line("home_months"); ?></option>
            <option value="Years" ><?php echo $this->lang->line("home_years"); ?></option>            
        </select>
        <button id="timeDialogClose"><?php echo $this->lang->line("home_search"); ?></button>
     </div>

    <div class="ui-state-error ui-corner-all error" id="error" style="display:none;" style="padding: 0 .7em;">
      <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <strong>{alert}:</strong>
         {error}
      </p>
    </div>
   	
	<script src="<?php echo $jquery_url; ?>"></script>
    <script src="<?php echo $jquery_ui_js_url; ?>"></script>
    <script src="<?php echo $base_url; ?><?php echo $js_url;?>chosen.jquery.min.js"></script>  
    <script src="<?php echo $base_url.$js_url;?>pusher.min.js"></script>
    <script type="text/javascript" src="<?= $base_url.$js_url."/error.js" ?>"></script>
	<script src="<?php echo $base_url.$js_url; ?>script.js"></script>	
    <script src="<?php echo $base_url.$js_url;?>standard.js"></script> 
    <script src="<?php echo $base_url.$js_url;?>view.js"></script>
</body>
</html>
