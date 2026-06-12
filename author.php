<?php get_header(); ?>

<section class="news ansor-mt-4rem">
    <div class="container">
        <div class="ansor_author_profile_wrapper">
            <?php 
            $author_id  = get_queried_object_id();
            $first_name = get_the_author_meta('first_name', $author_id);
            $last_name  = get_the_author_meta('last_name', $author_id);
            $full_name  = (!empty($first_name) || !empty($last_name)) ? trim($first_name . ' ' . $last_name) : get_the_author_meta('display_name', $author_id);
            $description = get_the_author_meta('description', $author_id);
            
            $instagram  = get_user_meta($author_id, 'ansor_instagram', true);
            $facebook   = get_user_meta($author_id, 'ansor_facebook', true);
            ?>

            <div class="ansor_author_box">
                <div class="ansor_author_avatar_side">
                    <div class="author_avatar_circle">
                        <?php echo get_avatar($author_id, 130); ?>
                    </div>
                </div>
                
                <div class="ansor_author_info_side">
                    <span class="author_badge_role">Tim Redaksi</span>
                    <h1 class="author_profile_name"><?php echo esc_html($full_name); ?></h1>
                    
                    <p class="author_profile_bio">
                        <?php if ( ! empty($description) ) : ?>
                            <?php echo esc_html($description); ?>
                        <?php else : ?>
                            Kader militan Pimpinan Cabang Gerakan Pemuda Ansor Kabupaten Pati yang aktif berkontribusi dalam menyampaikan syiar dan informasi seputar kegiatan keorganisasian.
                        <?php endif; ?>
                    </p>

                    <div class="author_profile_socials">
                        <?php if ( ! empty($instagram) ) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="author_soc_btn ig" aria-label="Instagram">
                                <i class="fa-brands fa-instagram"></i> <span>Instagram</span>
                            </a>
                        <?php endif; ?>

                        <?php if ( ! empty($facebook) ) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="author_soc_btn fb" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f"></i> <span>Facebook</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php 
        $page = get_option('posts_per_page');
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $current_author_id = get_queried_object_id();

        $authorPosts = new WP_Query(array(
            'post_type'         => 'post',
            'post_status'       => 'publish',
            'posts_per_page'    => $page,
            'paged'             => $paged,
            'author'            => $current_author_id
        ));

        if( $authorPosts->have_posts()){ ?>
            <div class="ansor_block">
                <div class="ansor_sidebar-used">
                    <div class="ansor_inner-post">
                        <div class="thi_inners" id="author-post-container">
                            <?php while( $authorPosts->have_posts()){
                                $authorPosts->the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" class="post_grid-item">
                                    <a href="<?php the_permalink(); ?>" class="url_grid-thumb">
                                        <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'news_thumb' ); ?>
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
                            <?php } ?>
                        </div>

                        <?php if( $authorPosts->max_num_pages > $paged ) : ?>
                            <br><br>
                            <center>
                                <span id="author_load_more" class="hero-btn" data-current-page="<?php echo $paged; ?>" data-max-pages="<?php echo $authorPosts->max_num_pages; ?>" data-author-id="<?php echo $current_author_id; ?>" data-nonce="<?php echo wp_create_nonce('ansor_author_load_more_nonce'); ?>" style="cursor:pointer; display: inline-flex; align-items: center; gap: 10px;">
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
                    const authorLoadBtn = document.getElementById('author_load_more');
                    const authorContainer = document.getElementById('author-post-container');

                    if (!authorLoadBtn || !authorContainer) return;

                    authorLoadBtn.addEventListener('click', function (){
                        let currentPage = parseInt(authorLoadBtn.getAttribute('data-current-page'));
                        const maxPages = parseInt(authorLoadBtn.getAttribute('data-max-pages'));
                        const authorId = authorLoadBtn.getAttribute('data-author-id');
                        const nonce = authorLoadBtn.getAttribute('data-nonce');
                        const spinner = authorLoadBtn.querySelector('.nm-spinner');
                        const btnText = authorLoadBtn.querySelector('span');

                        const nextPage = currentPage + 1;

                        if(nextPage > maxPages) return;

                        btnText.textContent = 'Memuat...';
                        spinner.style.display = 'block';
                        authorLoadBtn.style.pointerEvents = 'none';

                        const formData = new FormData();
                        formData.append('action', 'ansor_load_more_author_posts');
                        formData.append('page', nextPage);
                        formData.append('author_id', authorId);
                        formData.append('nonce', nonce);

                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() !== '') {
                                authorContainer.insertAdjacentHTML('beforeend', data);
                                authorLoadBtn.setAttribute('data-current-page', nextPage);
                                
                                btnText.textContent = 'Muat Lebih Banyak';
                                spinner.style.display = 'none';
                                authorLoadBtn.style.pointerEvents = 'auto';

                                if (nextPage >= maxPages) {
                                    authorLoadBtn.style.display = 'none';
                                }
                            } else {
                                authorLoadBtn.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            btnText.textContent = 'Muat Lebih Banyak';
                            spinner.style.display = 'none';
                            authorLoadBtn.style.pointerEvents = 'auto';
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