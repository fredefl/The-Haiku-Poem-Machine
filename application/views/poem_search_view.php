<!DOCTYPE html>
<html lang="en">
    <head>
    	<meta charset="utf-8">
    	<title><?php echo $this->lang->line("info_app_title");?> - <?php echo $this->lang->line("pages_home");?></title>
        <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>style.css">
        <link rel="stylesheet" href="<?php echo $base_url.$css_url; ?>styles.css">
        <link rel="stylesheet" href="<?php echo $jquery_ui_css_url;?>jquery-ui.css"/>
        <script type="text/javascript">
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

    <script src="<?php echo $jquery_url; ?>"></script>
    <script src="<?php echo $jquery_ui_js_url; ?>"></script>
    <script src="<?= $base_url.$js_url."/error.js" ?>"></script>
</body>
</html>
