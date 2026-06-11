<?php

add_action('wp_enqueue_scripts', function(){
    $pathCss = an_dir . '/assets/css/';
    $uriCss = an_uri . '/assets/css/';
    wp_enqueue_style( 'ansor-main-css', $uriCss . 'main.css', array(), fileatime( $pathCss . 'main.css'), 'all' );
});