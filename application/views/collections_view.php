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
            "anonymous" : "<?= $this->lang->line("info_anonymous"); ?>",
            "date_format" : "<?= $this->lang->line("home_date_time_format"); ?>",
            "alert" : "<?= $this->lang->line("errors_alert"); ?>",
            "not_found" : "<?= $this->lang->line("errors_no_collections_found") ?>"
        };
        var base_url = "<?= $base_url; ?>";
    </script>

    <input type="hidden" id="pages">
    <input type="hidden" id="page" value="1">
    <div style="margin-right:auto;margin-left:auto;width:500px;" id="collections-container">

        <div id="collections"m>

        </div>

        <div class="paginate box" style="font-size:18px;">
        	<button class="prev"><?= $this->lang->line("navigate_previus"); ?></button>
        	<span id="paginate-numbers">

            </span>
        	<button class="next"><?= $this->lang->line("navigate_next"); ?></button>
        </div>
    </div>

    <div id="template" style="display:none;">
            <a href="{base_url}{identifier}/view" style="min-height:400px;">
            <div class="box">
                <p class="center-text" style="font-size:18px;"><strong>{name}</strong></p>
                    
                    <div class="description">
                        {description}
                    </div>

                <p><strong><i></i></strong> {creator} - {date}</p>
            </div>
        </a>
    </div>

    <div class="errors-container" id="error">
        <div class="ui-state-error ui-corner-all error" style="display:none;">
          <p>
            <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
            <strong>{alert}:</strong>
             {error}
          </p>
        </div>
    </div>

	<script src="<?php echo $jquery_url; ?>"></script>
    <script src="<?php echo $jquery_ui_js_url; ?>"></script>
    <script type="text/javascript" src="<?= $base_url.$js_url."/error.js" ?>"></script>
    <script type="text/javascript" src="<?= $base_url.$js_url."/collections.js" ?>"></script>
    <script type="text/javascript">
    	$("button").button();
   	</script>
</body>
</html>
