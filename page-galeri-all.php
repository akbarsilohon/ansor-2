<?php get_header(); ?>

<br>
<section class="news ansor-mt-4rem" id="ansor_galeri_archive">
    <div class="container">
        <h2 class="section_heading">Semua <span>Galeri Kegiatan</span></h2>

        <?php
        $page = get_option('posts_per_page');
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $galeri_all_query = new WP_Query(array(
            'post_type'      => 'galeri',
            'post_status'    => 'publish',
            'posts_per_page' => $page,
            'paged'          => $paged,
            'order'          => 'DESC',
            'orderby'        => 'date'
        ));

        if ( $galeri_all_query->have_posts() ) { ?>
            <div class="ansor_block">
                <div class="ansor_galeri_grid" id="galeri-post-container" style="margin-top: 2.5rem;">
                    <?php while ( $galeri_all_query->have_posts() ) {
                        $galeri_all_query->the_post(); ?>
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
                    <?php } ?>
                </div>

                <?php if ( $galeri_all_query->max_num_pages > $paged ) : ?>
                    <br><br>
                    <center>
                        <span id="galeri_all_load_more" class="hero-btn" data-current-page="<?php echo $paged; ?>" data-max-pages="<?php echo $galeri_all_query->max_num_pages; ?>" data-nonce="<?php echo wp_create_nonce('ansor_galeri_all_nonce'); ?>" style="cursor:pointer; display: inline-flex; align-items: center; gap: 10px;">
                            <span>Muat Lebih Banyak</span>
                            <div class="nm-spinner" style="display:none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 0.8s linear infinite;"></div>
                        </span>
                    </center>
                    <style>
                        @keyframes spin { to { transform: rotate(360deg); } }
                    </style>
                <?php endif; ?>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const galeriLoadBtn = document.getElementById('galeri_all_load_more');
                    const galeriContainer = document.getElementById('galeri-post-container');

                    if (!galeriLoadBtn || !galeriContainer) return;

                    galeriLoadBtn.addEventListener('click', function () {
                        let currentPage = parseInt(galeriLoadBtn.getAttribute('data-current-page'));
                        const maxPages = parseInt(galeriLoadBtn.getAttribute('data-max-pages'));
                        const nonce = galeriLoadBtn.getAttribute('data-nonce');
                        const spinner = galeriLoadBtn.querySelector('.nm-spinner');
                        const btnText = galeriLoadBtn.querySelector('span');

                        const nextPage = currentPage + 1;

                        if (nextPage > maxPages) return;

                        btnText.textContent = 'Memuat...';
                        spinner.style.display = 'block';
                        galeriLoadBtn.style.pointerEvents = 'none';

                        const formData = new FormData();
                        formData.append('action', 'ansor_load_more_galeri_all');
                        formData.append('page', nextPage);
                        formData.append('nonce', nonce);

                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() !== '') {
                                galeriContainer.insertAdjacentHTML('beforeend', data);
                                galeriLoadBtn.setAttribute('data-current-page', nextPage);
                                
                                btnText.textContent = 'Muat Lebih Banyak';
                                spinner.style.display = 'none';
                                galeriLoadBtn.style.pointerEvents = 'auto';

                                if (nextPage >= maxPages) {
                                    galeriLoadBtn.style.display = 'none';
                                }
                            } else {
                                galeriLoadBtn.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            btnText.textContent = 'Muat Lebih Banyak';
                            spinner.style.display = 'none';
                            galeriLoadBtn.style.pointerEvents = 'auto';
                        });
                    });
                });
            </script>
        <?php } else { ?>
            <center><p>Belum ada dokumentasi galeri yang ditambahkan.</p></center>
        <?php }
        wp_reset_postdata();
        ?>
    </div>
</section>

<?php get_footer(); ?>