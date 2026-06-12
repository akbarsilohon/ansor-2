<?php get_header(); ?>

<br>
<section class="news ansor-mt-4rem" id="ansor_news">
    <div class="container">
        <h2 class="section_heading">
            <span><?php single_cat_title(); ?></span>
        </h2>

        <?php 
        $page = get_option('posts_per_page');
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $current_cat_id = get_queried_object_id();

        $postCatQuery = new WP_Query(array(
            'post_type'         => 'post',
            'post_status'       => 'publish',
            'posts_per_page'    => $page,
            'paged'             => $paged,
            'cat'               => $current_cat_id
        ));

        $i = 0;

        if( $postCatQuery->have_posts()){
            $count = $postCatQuery->post_count; ?>
            <div class="ansor_block">
                <?php 
                while( $i < min( 1, $count ) && $postCatQuery->have_posts() ){
                    $postCatQuery->the_post(); $i++; ?>
                    <article id="post-<?php the_ID(); ?>" class="new_first">
                        <div class="asset_mamen">
                            <h2 class="news_heading">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <span class="news_date">
                                <i class="fa-solid fa-calendar-days"></i>
                                <?php echo get_the_date(); ?>
                            </span>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="hero-btn">Selengkapnya</a>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="news_image">
                            <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'news_thumb' ); ?>
                        </a>
                    </article>
                    <?php
                }
                ?>

                <div class="ansor_sidebar-used">
                    <div class="ansor_inner-post">
                        <div class="thi_inners" id="cat-post-container">
                            <?php 
                            while( $postCatQuery->have_posts() ){
                                $postCatQuery->the_post(); $i++; ?>
                                <article id="post-<?php the_ID(); ?>" class="post_grid-item">
                                    <a href="<?php the_permalink(); ?>" class="url_grid-thumb">
                                        <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'news_thumb' ); ?>
                                    </a>
                                    <div class="grid_ast-kanan">
                                        <div class="nm-meta">
                                            <span>
                                                <i class="far fa-user"></i>
                                                <span class="nm-lbl-oleh">Oleh </span>
                                                <strong>
                                                    <?php $ids = get_post_field( 'post_author', get_the_ID()); ?>
                                                    <a href="<?php echo get_author_posts_url( $ids ); ?>">
                                                        <span><?php echo get_the_author_meta( 'display_name', $ids ); ?></span>
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
                            ?>
                        </div>

                        <?php if( $postCatQuery->max_num_pages > $paged ) : ?>
                            <br><br>
                            <center>
                                <span id="cat_load_more" class="hero-btn" data-current-page="<?php echo $paged; ?>" data-max-pages="<?php echo $postCatQuery->max_num_pages; ?>" data-category-id="<?php echo $current_cat_id; ?>" data-nonce="<?php echo wp_create_nonce('ansor_cat_load_more_nonce'); ?>" style="cursor:pointer; display: inline-flex; align-items: center; gap: 10px;">
                                    <span>Muat Lebih Banyak</span>
                                    <div class="nm-spinner" style="display:none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 0.8s linear infinite;"></div>
                                </span>
                            </center>
                            <style>
                                @keyframes spin { to { transform: rotate(360deg); } }
                            </style>
                        <?php endif; ?>
                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function (){
                    const catLoadMoreBtn = document.getElementById('cat_load_more');
                    const catPostContainer = document.getElementById('cat-post-container');

                    if (!catLoadMoreBtn || !catPostContainer) return;

                    catLoadMoreBtn.addEventListener('click', function (){
                        let currentPage = parseInt(catLoadMoreBtn.getAttribute('data-current-page'));
                        const maxPages = parseInt(catLoadMoreBtn.getAttribute('data-max-pages'));
                        const categoryId = catLoadMoreBtn.getAttribute('data-category-id');
                        const nonce = catLoadMoreBtn.getAttribute('data-nonce');
                        const spinner = catLoadMoreBtn.querySelector('.nm-spinner');
                        const btnText = catLoadMoreBtn.querySelector('span');

                        const nextPage = currentPage + 1;

                        if(nextPage > maxPages) return;

                        btnText.textContent = 'Memuat...';
                        spinner.style.display = 'block';
                        catLoadMoreBtn.style.pointerEvents = 'none';

                        const formData = new FormData();
                        formData.append('action', 'ansor_load_more_cat_posts');
                        formData.append('page', nextPage);
                        formData.append('category_id', categoryId);
                        formData.append('nonce', nonce);

                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() !== '') {
                                catPostContainer.insertAdjacentHTML('beforeend', data);
                                catLoadMoreBtn.setAttribute('data-current-page', nextPage);
                                
                                btnText.textContent = 'Muat Lebih Banyak';
                                spinner.style.display = 'none';
                                catLoadMoreBtn.style.pointerEvents = 'auto';

                                if (nextPage >= maxPages) {
                                    catLoadMoreBtn.style.display = 'none';
                                }
                            } else {
                                catLoadMoreBtn.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            btnText.textContent = 'Muat Lebih Banyak';
                            spinner.style.display = 'none';
                            catLoadMoreBtn.style.pointerEvents = 'auto';
                        });
                    });
                });
            </script>
            <?php
        }

        wp_reset_postdata();
        ?>
    </div>
</section>

<?php get_footer(); ?>