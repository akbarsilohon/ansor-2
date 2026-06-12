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



// Generate Post thumbnails ========================
function gp_ansor_thumbnail( $id, $size, $loading, $class ){
    $thumbnail = null;
    if( has_post_thumbnail( $id )){
        $thumbnail = the_post_thumbnail( $size, array(
            'class'     =>  $class,
            'loading'   =>  $loading
        ));
    }
    return $thumbnail;
}


// Excerpt more =======================
add_filter('excerpt_more', function(){
    return '..';
});

add_filter('excerpt_length', function(){
    return 25;
});


// render categroy text ============================
function ansor_cat_text(){
    $categories = get_the_category();
    $sparator = ', ';
    $output = '';
    $i = 1;

    if(!empty($categories)){
        foreach( $categories as $category ){
            if( $i > 1 ){
                $output .= $sparator;
            }

            $output = esc_html( $category->name );
        }
    }

    echo $output;
}

// Render category with link =======================
function ansor_cat_html_support( $class ){
    $categories = get_the_category();
    $sparator = ', ';
    $output = '';
    $i = 1;

    if(!empty($categories)){
        foreach( $categories as $category ){
            if( $i > 1 ){
                $output .= $sparator;
            }
            $output = '<a class="'. $class .'" href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="'. esc_html( $category->name ) .'">' . esc_html( $category->name ) . '</a>';
        }
    }

    return $output;
}


// Fungsi penabahan value pada popular post ==========
function ansor_pati_value_post_popular( $postID ){
    $metaKey = 'ansor_post_views';
    $views = get_post_meta( $postID, $metaKey, true );
    $count = ( empty( $views ) ? 0 : $views );
    $count++;

    update_post_meta( $postID, $metaKey, $count );
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );


// Estimasi timer baca ======================
function ansor_estimasi_waktu_baca() {
    $content = get_the_content();
    $clean_content = strip_shortcodes($content);
    $clean_content = strip_tags($clean_content);
    $word_count = str_word_count($clean_content);
    
    $reading_time = ceil($word_count / 150);
    
    return $reading_time . ' Menit';
}