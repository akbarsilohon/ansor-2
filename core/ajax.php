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