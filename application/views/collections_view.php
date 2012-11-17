<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->lang->line("info_app_title");?> - <?php echo $this->lang->line("pages_home");?></title>
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>style.css">
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>styles.css">
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>chosen.css" />
    <link rel="stylesheet" href="<?php echo $jquery_ui_css_url;?>jquery-ui.css"/>

    <div style="margin-right:auto;margin-left:auto;width:500px;">
    	<?php foreach ($collections as $collection): ?>
	    	<a href="<?= $base_url.$collection->identifier."/view" ?>">
		    	<div class="box">
		            <p class="center-text" style="font-size:18px;"><strong><?= $collection->name; ?></strong></p>
		            <?php if (!is_null($collection->description)): ?>
			            <div class="description">
			            	<?= $collection->description; ?>
			            </div>
		            <?php endif; ?>

		            <p><strong><i><?= (!is_null($collection->creator))? $collection->creator: $this->lang->line("info_anonymous"); ?></i></strong> - <?= date($this->lang->line("home_date_time_format"),$collection->time_created); ?></p>
		        </div>
	    	</a>
        <?php endforeach; ?>
    </div>

	<script src="<?php echo $jquery_url; ?>"></script>
    <script src="<?php echo $jquery_ui_js_url; ?>"></script>
</body>
</html>
