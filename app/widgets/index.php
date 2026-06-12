<?php

add_action('widgets_init', function() {
    register_sidebar( array(
        'name'          => 'Ansor Sidebar',
        'id'            => 'ansor-sidebar',
        'description'   => 'Ansor Sidebar Wordpress theme, The Beautiful sidebar',
        'before_widget' => '<div class="ansor-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="ansor-widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_widget( 'Ansor_Widget_Popular' );
});

require_once 'popular.php';