<?php get_header(); ?>

<br>
<section class="news ansor-mt-4rem" id="ansor_news">
    <div class="container">
        <h2 class="section_heading">Index <span>Berita</span></h2>
        
        <?php 
        $page = get_option('posts_per_page');
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $indexNews = new WP_Query(array(
            'post_type'         => 'post',
            'post_status'       => 'publish',
            'posts_per_page'    => $page,
            'paged'             => $paged
        ));

        $i = 0;

        if( $indexNews->have_posts() ) : 
            $count = $indexNews->post_count; ?>
            
            <div class="ansor_block">
                
                <?php 
                while( $i < min( 1, $count ) && $indexNews->have_posts() ) {
                    $indexNews->the_post(); $i++; ?>
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
                <?php } ?>

                <div class="ansor_sidebar-used">
                    <div class="ansor_inner-post">
                        <div class="thi_inners" id="post-container">
                            <?php 
                            while( $indexNews->have_posts() ) {
                                $indexNews->the_post(); $i++; ?>
                                <article id="post-<?php the_ID(); ?>" class="post_grid-item">
                                    <a href="<?php the_permalink(); ?>" class="url_grid-thumb">
                                        <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'news_thumb' ); ?>
                                    </a>
                                    <div class="grid_ast-kanan">
                                        <div class="grid_meta">
                                            <span class="the_author"><?php the_author(); ?></span>
                                            <span style="margin:0 6px; font-size:10px; color:#ccc;">.</span>
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
                            <?php } ?>
                        </div>

                        <?php if( $indexNews->max_num_pages > $paged ) : ?>
                            <br><br>
                            <center>
                                <span id="load_more" class="hero-btn" data-current-page="<?php echo $paged; ?>" data-max-pages="<?php echo $indexNews->max_num_pages; ?>" data-nonce="<?php echo wp_create_nonce('ansor_load_more_nonce'); ?>" style="cursor:pointer; display: inline-flex; align-items: center; gap: 10px;">
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
                    const loadMoreBtn = document.getElementById('load_more');
                    const postContainer = document.getElementById('post-container');

                    if (!loadMoreBtn || !postContainer) return;

                    loadMoreBtn.addEventListener('click', function (){
                        let currentPage = parseInt(loadMoreBtn.getAttribute('data-current-page'));
                        const maxPages = parseInt(loadMoreBtn.getAttribute('data-max-pages'));
                        const nonce = loadMoreBtn.getAttribute('data-nonce');
                        const spinner = loadMoreBtn.querySelector('.nm-spinner');
                        const btnText = loadMoreBtn.querySelector('span');

                        const nextPage = currentPage + 1;

                        if(nextPage > maxPages) return;

                        btnText.textContent = 'Memuat...';
                        spinner.style.display = 'block';
                        loadMoreBtn.style.pointerEvents = 'none';

                        const formData = new FormData();
                        formData.append('action', 'ansor_load_more_posts');
                        formData.append('page', nextPage);
                        formData.append('nonce', nonce);

                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() !== '') {
                                postContainer.insertAdjacentHTML('beforeend', data);
                                loadMoreBtn.setAttribute('data-current-page', nextPage);
                                
                                btnText.textContent = 'Muat Lebih Banyak';
                                spinner.style.display = 'none';
                                loadMoreBtn.style.pointerEvents = 'auto';

                                if (nextPage >= maxPages) {
                                    loadMoreBtn.style.display = 'none';
                                }
                            } else {
                                loadMoreBtn.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            btnText.textContent = 'Muat Lebih Banyak';
                            spinner.style.display = 'none';
                            loadMoreBtn.style.pointerEvents = 'auto';
                        });
                    });
                });
            </script>
        
        <?php else : ?>
            <center><p>Belum ada berita yang diterbitkan.</p></center>
        <?php 
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>

<?php get_footer(); ?>