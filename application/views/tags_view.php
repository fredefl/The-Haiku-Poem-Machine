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
            "no_results_found" : "<?= $this->lang->line("home_chosen_no_result"); ?>",
            "unlimited" : "<?= $this->lang->line("home_unlimited"); ?>"
        }
        var userLanguage = "<?php echo $this->ui_helper->language; ?>";
        var base_url = "<?= $base_url; ?>";

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

    body {
        width: 100%;
        height: auto;
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
<body> 

    <?php
    if (isset($poems)) {
    ?>

    <div id="view">
        <?php foreach ($poems as $poem): ?>
            <div class="box" style="width:480px;">
                <p style="font-size:22px;" class="center-text"><strong><?= $poem["title"]; ?></strong></p>
                <div class="text" style="margin-left:40px;">
                    <?php foreach ($poem["sentences"] as $sentence): ?>
                        <?= $sentence["sentence"]; ?><br>
                    <?php endforeach; ?>
                </div>
                <p><i> - <?= $poem["creator"]; ?> : <?= date($this->lang->line("home_date_time_format"),$poem["time_created"]); ?></i></p>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    }
    ?>

    <?php
    if (!isset($poems)) {
    ?>

        <div style="width:813px; margin-left:auto; margin-right:auto;">
            <div class="ui-state-error ui-corner-all error" id="error" style="padding: 0 .7em; max-width:300px; margin-left:auto; margin-right:auto;">
              <p>
                <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong><?php echo $this->lang->line("errors_alert"); ?>:</strong>
                 <?php
                    switch ($error) {
                        case 'no_poems':
                            echo $this->lang->line("errors_no_poems_found_for_tag");
                        break;
                        
                        case 'tag_not_found':
                            echo str_replace("{tag}", $tag, $this->lang->line("errors_tag_not_found"));
                        break;
                    }
                 ?>
              </p>
            </div>
        </div>
    <?php
    }
    ?>
   	
	<script src="<?php echo $jquery_url; ?>"></script>
    <script src="<?php echo $jquery_ui_js_url; ?>"></script>
    <script type="text/javascript">
        $("button").button();
        $('button[href]').live("click",function () {
            window.location = $(this).attr("href");
        });
    </script>
</body>
</html>