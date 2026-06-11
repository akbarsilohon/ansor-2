<?php

// After setup theme ==========================
add_action('after_setup_theme', function(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    add_theme_support('responsive-embeds');
    
    register_nav_menus(array(
        'primary'   =>  __('Primary Menu', 'ansor-2')
    ));
});

// WP Generator ===============================
add_filter('the_generator', function(){
    return '<meta name="generator" content="Silohon CMS" />';
});

function ansor_disable_feed() {
    wp_redirect( home_url() );
    exit;
}
add_action('do_feed', 'ansor_disable_feed', 1);
add_action('do_feed_rdf', 'ansor_disable_feed', 1);
add_action('do_feed_rss', 'ansor_disable_feed', 1);
add_action('do_feed_rss2', 'ansor_disable_feed', 1);
add_action('do_feed_atom', 'ansor_disable_feed', 1);
add_action('do_feed_rss2_comments', 'ansor_disable_feed', 1);
add_action('do_feed_atom_comments', 'ansor_disable_feed', 1);