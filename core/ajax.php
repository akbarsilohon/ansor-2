<?php

// Ajax Berita Index =======================
function ansor_ajax_load_more_posts() {
    check_ajax_referer('ansor_load_more_nonce', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = get_option('posts_per_page');

    $query = new WP_Query(array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="post_grid-item">
                <a href="<?php the_permalink(); ?>" class="url_grid-thumb">
                    <?php echo gp_ansor_thumbnail(get_the_ID(), 'full', 'lazy', 'news_thumb'); ?>
                </a>
                <div class="grid_ast-kanan">
                    <div class="grid_meta">
                        <span class="the_author"><?php the_author(); ?></span>
                        <span style="margin:0 6px; font-size:10px; color:#ccc;">&gt;</span>
                        <span class="is_post-cat"><?php echo ansor_cat_text(); ?></span>
                    </div>
                    <h3 class="grid_post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php the_excerpt(); ?>
                    <span class="news_date">
                        <i class="fa-solid fa-calendar-days"></i>
                        <?php echo get_the_date(); ?>
                    </span>
                </div>
            </article>
            <?php
        }
    }
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_ansor_load_more_posts', 'ansor_ajax_load_more_posts');
add_action('wp_ajax_nopriv_ansor_load_more_posts', 'ansor_ajax_load_more_posts');


// Ajax load more category ================
function ansor_ajax_load_more_cat_posts() {
    check_ajax_referer('ansor_cat_load_more_nonce', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $posts_per_page = get_option('posts_per_page');

    $query = new WP_Query(array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'cat'            => $category_id
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="post_grid-item">
                <a href="<?php the_permalink(); ?>" class="url_grid-thumb">
                    <?php echo gp_ansor_thumbnail(get_the_ID(), 'full', 'lazy', 'news_thumb'); ?>
                </a>
                <div class="grid_ast-kanan">
                    <div class="nm-meta">
                        <span>
                            <i class="far fa-user"></i>
                            <span class="nm-lbl-oleh">Oleh </span>
                            <strong>
                                <?php $ids = get_post_field('post_author', get_the_ID()); ?>
                                <a href="<?php echo get_author_posts_url($ids); ?>">
                                    <span><?php echo get_the_author_meta('display_name', $ids); ?></span>
                                </a>
                            </strong>
                        </span>
                    </div>
                    <h3 class="grid_post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php the_excerpt(); ?>
                    <span class="news_date">
                        <i class="fa-solid fa-calendar-days"></i>
                        <?php echo get_the_date(); ?>
                    </span>
                </div>
            </article>
            <?php
        }
    }
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_ansor_load_more_cat_posts', 'ansor_ajax_load_more_cat_posts');
add_action('wp_ajax_nopriv_ansor_load_more_cat_posts', 'ansor_ajax_load_more_cat_posts');


// Ansor load more post by author ===========
function ansor_ajax_load_more_author_posts() {
    check_ajax_referer('ansor_author_load_more_nonce', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $author_id = isset($_POST['author_id']) ? intval($_POST['author_id']) : 0;
    $posts_per_page = get_option('posts_per_page');

    $query = new WP_Query(array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'author'         => $author_id
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="post_grid-item">
                <a href="<?php the_permalink(); ?>" class="url_grid-thumb">
                    <?php echo gp_ansor_thumbnail(get_the_ID(), 'full', 'lazy', 'news_thumb'); ?>
                </a>
                <div class="grid_ast-kanan">
                    <div class="nm-meta">
                        <span style="color: var(--accent); font-weight: bold;">
                            <span class="nm-lbl-menit"><?php echo ansor_cat_text(); ?></span> 
                        </span>
                    </div>
                    <h3 class="grid_post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php the_excerpt(); ?>
                    <span class="news_date">
                        <i class="fa-solid fa-calendar-days"></i>
                        <?php echo get_the_date(); ?>
                    </span>
                </div>
            </article>
            <?php
        }
    }
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_ansor_load_more_author_posts', 'ansor_ajax_load_more_author_posts');
add_action('wp_ajax_nopriv_ansor_load_more_author_posts', 'ansor_ajax_load_more_author_posts');


// Load more post for tag ============================
function ansor_ajax_load_more_tag_posts() {
    check_ajax_referer('ansor_tag_load_more_nonce', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $tag_id = isset($_POST['tag_id']) ? intval($_POST['tag_id']) : 0;
    $posts_per_page = get_option('posts_per_page');

    $query = new WP_Query(array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'tag_id'         => $tag_id
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="post_grid-item">
                <a href="<?php the_permalink(); ?>" class="url_grid-thumb">
                    <?php echo gp_ansor_thumbnail(get_the_ID(), 'full', 'lazy', 'news_thumb'); ?>
                </a>
                <div class="grid_ast-kanan">
                    <div class="nm-meta">
                        <span>
                            <i class="far fa-user"></i>
                            <span class="nm-lbl-oleh">Oleh </span>
                            <strong>
                                <?php $ids = get_post_field('post_author', get_the_ID()); ?>
                                <a href="<?php echo get_author_posts_url($ids); ?>">
                                    <span><?php echo get_the_author_meta('display_name', $ids); ?></span>
                                </a>
                            </strong>
                        </span>
                        <span>•</span>
                        <span style="color: var(--accent); font-weight: bold;">
                            <span class="nm-lbl-menit"><?php echo ansor_cat_text(); ?></span> 
                        </span>
                    </div>
                    <h3 class="grid_post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php the_excerpt(); ?>
                    <span class="news_date">
                        <i class="fa-solid fa-calendar-days"></i>
                        <?php echo get_the_date(); ?>
                    </span>
                </div>
            </article>
            <?php
        }
    }
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_ansor_load_more_tag_posts', 'ansor_ajax_load_more_tag_posts');
add_action('wp_ajax_nopriv_ansor_load_more_tag_posts', 'ansor_ajax_load_more_tag_posts');


// Load more Post type Gallery ========================
function ansor_ajax_load_more_galeri_all() {
    check_ajax_referer('ansor_galeri_all_nonce', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = get_option('posts_per_page');

    $query = new WP_Query(array(
        'post_type'      => 'galeri',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'order'          => 'DESC',
        'orderby'        => 'date'
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <article id="galeri-<?php the_ID(); ?>" class="galeri_card_item">
                <a href="<?php the_permalink(); ?>" class="galeri_card_thumb">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('medium_large', array('loading' => 'lazy')); ?>
                    <?php else : ?>
                        <div class="galeri_placeholder">
                            <i class="fa-solid fa-images"></i>
                        </div>
                    <?php endif; ?>
                    <div class="galeri_card_overlay">
                        <span class="galeri_zoom_icon">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </span>
                    </div>
                </a>
                <div class="galeri_card_info">
                    <span class="galeri_card_date">
                        <i class="fa-solid fa-calendar-day"></i> <?php echo get_the_date('d M Y'); ?>
                    </span>
                    <h3 class="galeri_card_title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
            </article>
            <?php
        }
    }
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_ansor_load_more_galeri_all', 'ansor_ajax_load_more_galeri_all');
add_action('wp_ajax_nopriv_ansor_load_more_galeri_all', 'ansor_ajax_load_more_galeri_all');


// Load more dan filter program kerja =====================
function ansor_ajax_filter_program_posts() {
    check_ajax_referer('ansor_program_nonce', 'nonce');

    $paged          = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category       = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $date_from      = isset($_POST['date_from']) ? sanitize_text_field($_POST['date_from']) : '';
    $date_to        = isset($_POST['date_to']) ? sanitize_text_field($_POST['date_to']) : '';
    $posts_per_page = get_option('posts_per_page');

    $args = array(
        'post_type'      => 'program_kerja',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'order'          => 'DESC',
        'orderby'        => 'date'
    );

    if ( $category !== 'all' ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'kategori_program',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    if ( ! empty($date_from) || ! empty($date_to) ) {
        $args['date_query'] = array(array('inclusive' => true));
        if ( ! empty($date_from) ) {
            $args['date_query'][0]['after'] = $date_from;
        }
        if ( ! empty($date_to) ) {
            $args['date_query'][0]['before'] = $date_to;
        }
    }

    $query = new WP_Query($args);
    $html = '';

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id   = get_the_ID();
            $status    = get_post_meta($post_id, '_program_status', true);
            $waktu     = get_post_meta($post_id, '_program_waktu', true);
            $lokasi    = get_post_meta($post_id, '_program_lokasi', true);
            
            $terms = get_the_terms($post_id, 'kategori_program');
            $kategori_name = ($terms && ! is_wp_error($terms)) ? $terms[0]->name : 'Umum';

            $status_label = 'Direncanakan';
            $status_class = 'planned';
            if ($status === 'In Progress') { $status_label = 'Berjalan'; $status_class = 'progress'; }
            elseif ($status === 'Completed') { $status_label = 'Selesai'; $status_class = 'completed'; }
            elseif ($status === 'Routine') { $status_label = 'Berkala'; $status_class = 'routine'; }
            
            ob_start(); ?>
            <article id="program-<?php the_ID(); ?>" class="program_card_item">
                <a href="<?php the_permalink(); ?>" class="program_card_thumb">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('medium_large', array('loading' => 'lazy')); ?>
                    <?php else : ?>
                        <div class="program_placeholder">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                    <?php endif; ?>
                    <span class="program_status_badge <?php echo $status_class; ?>"><?php echo esc_html($status_label); ?></span>
                </a>
                
                <div class="program_card_info">
                    <span class="program_card_cat"><?php echo esc_html($kategori_name); ?></span>
                    <h3 class="program_card_title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    
                    <div class="program_card_meta">
                        <span><i class="fa-solid fa-calendar-day"></i> <?php echo esc_html($waktu); ?></span>
                        <span><i class="fa-solid fa-location-dot"></i> <?php echo esc_html($lokasi); ?></span>
                    </div>

                    <div class="program_card_excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" class="program_card_btn">Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </article>
            <?php
            $html .= ob_get_clean();
        }
    } else {
        if ($paged === 1) {
            $html = '<center id="program-empty-msg" style="grid-column: 1/-1;"><p>Tidak ada program kegiatan yang sesuai dengan filter.</p></center>';
        }
    }

    $max_pages = $query->max_num_pages;
    wp_reset_postdata();

    wp_send_json_success(array(
        'html'      => $html,
        'max_pages' => $max_pages
    ));
}
add_action('wp_ajax_ansor_filter_program_posts', 'ansor_ajax_filter_program_posts');
add_action('wp_ajax_nopriv_ansor_filter_program_posts', 'ansor_ajax_filter_program_posts');


// Load more category program kerja =========================
function ansor_ajax_load_more_program_taxonomy() {
    check_ajax_referer('ansor_program_tax_nonce', 'nonce');

    $paged          = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $term_id        = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;
    $posts_per_page = get_option('posts_per_page');

    $args = array(
        'post_type'      => 'program_kerja',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'order'          => 'DESC',
        'orderby'        => 'date',
        'tax_query'      => array(
            array(
                'taxonomy' => 'kategori_program',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ( $query->have_posts() ) {
        $current_term = get_term($term_id, 'kategori_program');
        $kategori_name = ( ! is_wp_error($current_term) && $current_term ) ? $current_term->name : 'Umum';

        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id   = get_the_ID();
            $status    = get_post_meta($post_id, '_program_status', true);
            $waktu     = get_post_meta($post_id, '_program_waktu', true);
            $lokasi    = get_post_meta($post_id, '_program_lokasi', true);
            
            $status_label = 'Direncanakan';
            $status_class = 'planned';
            if ($status === 'In Progress') { $status_label = 'Berjalan'; $status_class = 'progress'; }
            elseif ($status === 'Completed') { $status_label = 'Selesai'; $status_class = 'completed'; }
            elseif ($status === 'Routine') { $status_label = 'Berkala'; $status_class = 'routine'; }
            ?>
            <article id="program-<?php the_ID(); ?>" class="program_card_item">
                <a href="<?php the_permalink(); ?>" class="program_card_thumb">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('medium_large', array('loading' => 'lazy')); ?>
                    <?php else : ?>
                        <div class="program_placeholder">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                    <?php endif; ?>
                    <span class="program_status_badge <?php echo $status_class; ?>"><?php echo esc_html($status_label); ?></span>
                </a>
                
                <div class="program_card_info">
                    <span class="program_card_cat"><?php echo esc_html($kategori_name); ?></span>
                    <h3 class="program_card_title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    
                    <div class="program_card_meta">
                        <span><i class="fa-solid fa-calendar-day"></i> <?php echo esc_html($waktu); ?></span>
                        <span><i class="fa-solid fa-location-dot"></i> <?php echo esc_html($lokasi); ?></span>
                    </div>

                    <div class="program_card_excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" class="program_card_btn">Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </article>
            <?php
        }
    }
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_ansor_load_more_program_taxonomy', 'ansor_ajax_load_more_program_taxonomy');
add_action('wp_ajax_nopriv_ansor_load_more_program_taxonomy', 'ansor_ajax_load_more_program_taxonomy');