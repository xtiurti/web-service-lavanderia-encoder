<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <base href="<?php echo URL_APPLICATION ?>" />

        <title>ENCODER</title>

        <?php
        echo css(array(
            # scripts enginers
            '../lib/materializecss/css/materialize.min',
            '../lib/materializecss/css/google-material-icons',
            '../lib/inspinia/css/animate',
            '../lib/inspinia/css/toastr.min',
            
            # scripts by myself
            'style'
        ));
        ?>
    </head>

    <body class="grey lighten-5">
        <?php echo view('@elements/page/load'); ?>

        <div class="page_content vertical align">
            <?php echo flashes(); ?>
            <?php echo view_yield() ?>
        </div>
        
        <?php
        echo js(array(
            # scripts enginers
            '../lib/js/manifest.min', # << jquery, cryptography, mask_input, masked, maskmoney, ?
            '../lib/inspinia/js/toastr.min',
            '../lib/materializecss/js/materialize.min',
            
            # scripts by myself
            'functions_before_load',
            'app/init',
            'app/' . locale(), # script reference current view
            'functions_after_load',
        ));
        ?>
    </body>
</html>