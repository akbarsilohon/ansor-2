<?php

add_action('wp_enqueue_scripts', function(){
    $pathCss = an_dir . '/assets/css/';
    $uriCss = an_uri . '/assets/css/';

    $jsPath = an_dir . '/assets/js/main.js';
    $jsUri = an_uri . '/assets/js/main.js';

    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2', 'all');
    wp_enqueue_style( 'ansor-main-css', $uriCss . 'main.css', array(), fileatime( $pathCss . 'main.css'), 'all' );
    wp_enqueue_script( 'ansor-main-js', $jsUri, array(), fileatime( $jsPath ), true );
});



// Default favicon ==========================
$siteIcon = get_site_icon_url();
if( empty( $siteIcon )){
    add_action('wp_head', 'ansor_generate_site_icon_default');
    add_action('admin_head', 'ansor_generate_site_icon_default');
    add_action('login_head', 'ansor_generate_site_icon_default');
}
function ansor_generate_site_icon_default(){ ?>
    <link rel="shortcut icon" href="<?php echo esc_url( an_fav ); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo esc_url( an_fav ); ?>">
    <?php
}



// Logo login WP Ansor =====================
add_action('login_head', function(){
    $option = get_option('gp_ansor', []);
    $logo = isset($option['logo']) && !empty($option['logo']) ? $option['logo'] : an_logo; ?>
    <style>
        .login h1 a {
            background-image: url('<?php echo esc_url($logo); ?>') !important;
            background-size: contain;
            width: 100%;
            height: 60px;
        }
        .login h1 a:focus {
            box-shadow: none;
        }
    </style>
    <?php
});

function ansor_add_dropdown_icon( $title, $item, $args, $depth ) {
    if ( $args->theme_location == 'primary' && $depth === 0 && in_array( 'menu-item-has-children', $item->classes ) ) {
        $title .= ' <span class="menu-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
    }
    return $title;
}
add_filter( 'nav_menu_item_title', 'ansor_add_dropdown_icon', 10, 4 );


// Register css for Custom post ===================================
add_action('admin_enqueue_scripts', function( $hook ){
    if ( ! in_array($hook, array('post.php', 'post-new.php')) ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen ) {
        return;
    }

    $allowed_post_types = array('pengurus');
    if ( in_array($screen->post_type, $allowed_post_types) ) {
        wp_enqueue_style( 'ansor-google-font', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap', array(), null, 'all' );
        wp_enqueue_style(
            'admin-custom-post-css',
            an_uri . '/assets/css/post-cpt.css',
            array(), 
            fileatime( an_dir . '/assets/css/post-cpt.css'), 
            'all'
        );
    }
});