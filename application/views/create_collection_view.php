<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->lang->line("info_app_title");?> - <?php echo $this->lang->line("pages_create_collection");?></title>
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>style.css">
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>styles.css">
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>chosen.css" />
    <link rel="stylesheet" href="<?php echo $jquery_ui_css_url;?>jquery-ui.css"/>
    <script type="text/javascript">
        var js_url = "<?php echo  $base_url.$js_url ?>";
        var translations = {
            "alert" : "<?= $this->lang->line("errors_alert"); ?>",
            "missing_fields" : "<?= $this->lang->line("errors_fields_missing"); ?>",
            "no_sentences_match" : "<?= $this->lang->line("errors_no_sentences_matching"); ?>",
            "an_error_occured" : "<?= $this->lang->line("errors_an_error_occured"); ?>",
            "no_results_found" : "<?= $this->lang->line("home_chosen_no_result"); ?>",
            "add_button_text" : "<?= $this->lang->line("collection_add"); ?>",
            "edit_button_text" : "<?= $this->lang->line("collection_edit"); ?>",
            "syllabels_text" : "<?= $this->lang->line("home_syllabels"); ?>",
            "unlimited" : "<?= $this->lang->line("home_unlimited"); ?>"
        }
        var userLanguage = "<?php echo $this->ui_helper->language; ?>";
        var base_url = "<?= $base_url; ?>";
        var selects = ["5","7"];
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
<bod> 
	<input id="base_url" value="<?php echo $base_url; ?>" type="hidden">
    <input type="hidden" id="current_time" value="<?php echo $current_time ?>">

    <div id="create">
        <div id="Container">
            <ul id="questions" style="padding: 0;">
                <li>
                    <p id="title"><?php echo $this->lang->line("collection_create"); ?></p>

                    <select data-placeholder="<?= $this->lang->line("collection_languages"); ?>" id="languages-select" multiple>
                        <?php 
                            foreach ($this->config->item("supported_languages_values") as $name => $value) {
                                echo '<option value="'.$value.'">'.$name.'</option>';
                            }
                        ?>
                    </select><br>

                    <div class="chzn-container chzn-container-multi shadow" style="width: 300px; margin-top:15px;">
                        <ul class="chzn-choices">
                            <li class="search-field">
                                <input type="text" required placeholder="<?php echo $this->lang->line("home_creator"); ?>" id="creator" name="name" class="default" style="width: 300px;">
                            </li>
                        </ul>
                    </div>

                    <div class="chzn-container chzn-container-multi shadow" style="width: 300px; margin-top:15px;">
                        <ul class="chzn-choices">
                            <li class="search-field">
                                <input type="text" required placeholder="<?php echo $this->lang->line("home_name"); ?>" id="name" name="title" class="default" style="width: 300px;">
                            </li>
                        </ul>
                    </div>

                    <div class="chzn-container chzn-container-multi shadow" style="width: 300px; margin-top:15px;margin-bottom:15px;">
                        <ul class="chzn-choices">
                            <li class="search-field">
                                <input type="text" required placeholder="<?php echo $this->lang->line("home_description"); ?>" id="description" name="description" class="default" style="width: 300px;">
                            </li>
                        </ul>
                    </div>

                    <div class="chzn-container chzn-container-single syllabels-select" data-value="5" data-select-id="1" style="width: 300px; margin-bottom:10px;">
                        <a class="chzn-single chzn-default">
                            <span>5</span>
                            <div><b></b></div>
                        </a>
                    </div>

                    <img src="<?php echo $base_url; ?>assets/images/add.png" style="margin-right:-20px; margin-left:5px; margin-top:px; cursor:pointer;" class="addSelect"></img>

                    <button id="submitButton"  style="width:300px;margin-top:10px;"><?php echo $this->lang->line("collection_create_button"); ?></button>    
                </li>
            </ul>
        </div>

        <div id="copyrightContainer">
            <div id="copyright">
                <a style="color:#70777a;" href="https://illution.dk"><?php echo $this->lang->line("info_copyright"); ?></a>
            </div>
        </div>
    </div>

    <div id="done" class="disabledPage">
        <div id="Container">
            <ul id="questions" style="padding: 0;">
                <li>
                    <div class="chzn-container chzn-container-multi shadow" style="width: 300px; margin-top:15px;">
                        <ul class="chzn-choices">
                            <li class="search-field">
                                <input type="text" id="url" class="default" style="width: 300px;">
                            </li>
                        </ul>
                    </div><br>
                    <button id="copy" style="width:150px;"><?php echo $this->lang->line("collection_copy"); ?></button>
                    <a id="go" href="" style="width:150px;"><?php echo $this->lang->line("collection_go"); ?></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="ui-state-error ui-corner-all error" id="error" style="display:none;" style="padding: 0 .7em;">
      <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <strong>{alert}:</strong>
         {error}
      </p>
    </div>

    <div id="selectSyllabelsDialog" title="<?php echo $this->lang->line("collection_select_syllabels"); ?>" data-mode="add" style="display:none; overflow:hidden">
        <p><?php echo $this->lang->line("collection_select_syllabels_description"); ?></p>
        <input type="text" id="Syllabels" style="width:262px;">
        <button id="syllabelsDialogClose" style="width:265px;"><?php echo $this->lang->line("collection_add"); ?></button>
    </div>
   	
	<script src="<?php echo $jquery_url; ?>"></script>
    <script src="<?php echo $jquery_ui_js_url; ?>"></script>
    <script src="<?php echo $base_url; ?><?php echo $js_url;?>chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?= $base_url.$js_url."/jquery.zclip.min.js " ?>"></script>
    <script type="text/javascript" src="<?= $base_url.$js_url."/error.js" ?>"></script>
    <script type="text/javascript" src="<?= $base_url.$js_url."/collection.js" ?>"></script>
    <script type="text/javascript">
        $("#languages-select").chosen({
            no_results_text: translations.no_results_found
        });
        $("#submitButton").button();
        $("#syllabelsDialogClose").button();
        $('.syllabels-select:first').find("span").text(translations.syllabels_text.replace("{number_of_syllabels}","5"));
        $("#copy").button();
        $("#go").button();
    </script>
</body>
</html>
