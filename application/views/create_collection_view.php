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
        var translations = {
            "alert" : "<?= $this->lang->line("errors_alert"); ?>",
            "missing_fields" : "<?= $this->lang->line("errors_fields_missing"); ?>",
            "no_sentences_match" : "<?= $this->lang->line("errors_no_sentences_matching"); ?>",
            "an_error_occured" : "<?= $this->lang->line("errors_an_error_occured"); ?>",
            "no_results_found" : "<?= $this->lang->line("home_chosen_no_result"); ?>"
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

                    <div class="chzn-container chzn-container-multi" style="width: 300px; margin-top:15px;">
                        <ul class="chzn-choices">
                            <li class="search-field">
                                <input type="text" placeholder="<?php echo $this->lang->line("home_creator"); ?>" id="creator" class="default" style="width: 300px;">
                            </li>
                        </ul>
                    </div>

                    <div class="chzn-container chzn-container-multi" style="width: 300px; margin-top:15px;margin-bottom:15px;">
                        <ul class="chzn-choices">
                            <li class="search-field">
                                <input type="text" placeholder="<?php echo $this->lang->line("home_name"); ?>" id="name" class="default" style="width: 300px;">
                            </li>
                        </ul>
                    </div>

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
    <script type="text/javascript" src="<?= $base_url.$js_url."/error.js" ?>"></script>
    <script type="text/javascript" src="<?= $base_url.$js_url."/collection.js" ?>"></script>
    <script type="text/javascript">
        $("#languages-select").chosen({
            no_results_text: translations.no_results_found
        });
        $("#submitButton").button();
    </script>
</body>
</html>
