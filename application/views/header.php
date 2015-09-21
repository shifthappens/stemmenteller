<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?=$this->config->item('festival_name') ?> StemmenTeller</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>css/main.css">
        <script src="<?=base_url()?>js/vendor/modernizr-2.6.2.min.js"></script>
        <base href="<?=base_url()?>"></base>
        <style tye="text/css">
            body.rankings { 
              background: url('./uploads/<?=$this->config->item('background_image_url')?>') no-repeat fixed;
              background-size: cover; 
              filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./uploads/<?=$this->config->item('background_image_url')?>', sizingMethod='scale');
              -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./uploads/<?=$this->config->item('background_image_url')?>', sizingMethod='scale')";
            }        
        </style>
    </head>
    <body class="<?=$this->uri->segment(1, 'rankings').' '.$this->uri->segment(2, 'index')?>">