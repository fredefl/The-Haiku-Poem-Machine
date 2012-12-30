<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->lang->line("info_app_title");?> - <?php echo $this->lang->line("pages_poem");?></title>
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>style.css">
    <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>styles.css">
    <link rel="stylesheet" href="<?= $jquery_ui_css_url;?>jquery-ui.css"/>
    <script type="text/javascript">
        var userLanguage = "<?php echo $this->ui_helper->language; ?>";
    </script>
    <!--[if lt IE 9]>
          <script src="<?php echo $html5_shiv_url; ?>"></script>
    <![endif]-->
    <style type="text/css">
	@font-face {
		font-family: "Bonzai";
		src: url(<?php echo $base_url; ?><?php echo $fonts_url;?>bonzai.ttf);
	}
	
	.text{
		font-family: "Bonzai";
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
   	
    <div id="Container">
        <div class="box">
            <p class="center-text"><strong><?= $poem->title; ?></strong></p>
            <div class="text" style="margin-left:40px;">
                <?php if (count($poem->sentences)) {
                    foreach ($poem->sentences as $sentence) {
                        echo $sentence->sentence."<br>";
                    }
                } ?>
            </div>
            <p><i> - <?= $poem->creator; ?></i></p>
        </div>
    <div>

	<script src="<?php echo $jquery_url; ?>"></script>
    <script src="<?php echo $jquery_ui_js_url; ?>"></script>
</body>
</html>
