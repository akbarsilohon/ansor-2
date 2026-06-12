<?php get_header(); ?>

<br>
<section class="news ansor-mt-4rem" id="ansor_news">
    <div class="container">
        <h2 class="section_heading">
            Tag <span><?php single_tag_title(); ?></span>
        </h2>

        <?php
        $page = get_option('posts_per_page');
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $current_tag_id = get_queried_object_id();

        $tagPosts = new WP_Query(array(
            'post_type'         => 'post',
            'post_status'       => 'publish',
            'posts_per_page'    => $page,
            'paged'             => $paged,
            'tag_id'            => $current_tag_id
        ));

        if( $tagPosts->have_posts()){ ?>
            <div class="ansor_block">
                <div class="ansor_sidebar-used">
                    <div class="ansor_inner-post">
                        <div class="thi_inners" id="tag-post-container">
                            <?php while( $tagPosts->have_posts()){
                                $tagPosts->the_post(); ?>
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
                            <?php } ?>
                        </div>

                        <?php if( $tagPosts->max_num_pages > $paged ) : ?>
                            <br><br>
                            <center>
                                <span id="tag_load_more" class="hero-btn" data-current-page="<?php echo $paged; ?>" data-max-pages="<?php echo $tagPosts->max_num_pages; ?>" data-tag-id="<?php echo $current_tag_id; ?>" data-nonce="<?php echo wp_create_nonce('ansor_tag_load_more_nonce'); ?>" style="cursor:pointer; display: inline-flex; align-items: center; gap: 10px;">
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
                    const tagLoadMoreBtn = document.getElementById('tag_load_more');
                    const tagPostContainer = document.getElementById('tag-post-container');

                    if (!tagLoadMoreBtn || !tagPostContainer) return;

                    tagLoadMoreBtn.addEventListener('click', function (){
                        let currentPage = parseInt(tagLoadMoreBtn.getAttribute('data-current-page'));
                        const maxPages = parseInt(tagLoadMoreBtn.getAttribute('data-max-pages'));
                        const tagId = tagLoadMoreBtn.getAttribute('data-tag-id');
                        const nonce = tagLoadMoreBtn.getAttribute('data-nonce');
                        const spinner = tagLoadMoreBtn.querySelector('.nm-spinner');
                        const btnText = tagLoadMoreBtn.querySelector('span');

                        const nextPage = currentPage + 1;

                        if(nextPage > maxPages) return;

                        btnText.textContent = 'Memuat...';
                        spinner.style.display = 'block';
                        tagLoadMoreBtn.style.pointerEvents = 'none';

                        const formData = new FormData();
                        formData.append('action', 'ansor_load_more_tag_posts');
                        formData.append('page', nextPage);
                        formData.append('tag_id', tagId);
                        formData.append('nonce', nonce);

                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() !== '') {
                                tagPostContainer.insertAdjacentHTML('beforeend', data);
                                tagLoadMoreBtn.setAttribute('data-current-page', nextPage);
                                
                                btnText.textContent = 'Muat Lebih Banyak';
                                spinner.style.display = 'none';
                                tagLoadMoreBtn.style.pointerEvents = 'auto';

                                if (nextPage >= maxPages) {
                                    tagLoadMoreBtn.style.display = 'none';
                                }
                            } else {
                                tagLoadMoreBtn.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            btnText.textContent = 'Muat Lebih Banyak';
                            spinner.style.display = 'none';
                            tagLoadMoreBtn.style.pointerEvents = 'auto';
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