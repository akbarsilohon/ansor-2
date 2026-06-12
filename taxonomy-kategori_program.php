<?php get_header(); ?>

<br>
<section class="ansor-mt-4rem">
    <div class="container">
        
        <header class="taxonomy_program_header" style="margin-bottom: 3.5rem; text-align: center;">
            <h2 class="section_heading">Kategori Program: <span><?php single_term_title(); ?></span></h2>
            <?php 
            $term_description = term_description();
            if ( ! empty( $term_description ) ) : ?>
                <div class="taxonomy_program_desc" style="color: var(--base-2); font-size: 15px; max-width: 700px; margin: 1rem auto 0 auto; line-height: 1.6;">
                    <?php echo $term_description; ?>
                </div>
            <?php endif; ?>
        </header>

        <?php 
        $per_page = get_option('posts_per_page');
        $paged    = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $current_term = get_queried_object();

        $args = array(
            'post_type'      => 'program_kerja',
            'posts_per_page' => $per_page,
            'post_status'    => 'publish',
            'paged'          => $paged,
            'order'          => 'DESC',
            'orderby'        => 'date',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'kategori_program',
                    'field'    => 'term_id',
                    'terms'    => $current_term->term_id,
                ),
            ),
        );

        $taxonomy_query = new WP_Query($args);
        ?>

        <div class="ansor_program_grid" id="program-taxonomy-container">
            <?php if ( $taxonomy_query->have_posts() ) : ?>
                <?php while ( $taxonomy_query->have_posts() ) : $taxonomy_query->the_post(); 
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
                            <span class="program_card_cat"><?php echo esc_html($current_term->name); ?></span>
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
                <?php endwhile; ?>
            <?php else : ?>
                <center style="grid-column: 1/-1;"><p>Belum ada program kerja di kategori ini.</p></center>
            <?php endif; ?>
        </div>

        <?php if ( $taxonomy_query->max_num_pages > $paged ) : ?>
            <br><br>
            <center>
                <span id="program_tax_load_more" class="hero-btn" 
                      data-current-page="<?php echo $paged; ?>" 
                      data-max-pages="<?php echo $taxonomy_query->max_num_pages; ?>" 
                      data-term-id="<?php echo $current_term->term_id; ?>"
                      data-nonce="<?php echo wp_create_nonce('ansor_program_tax_nonce'); ?>" 
                      style="cursor:pointer; display: inline-flex; align-items: center; gap: 10px;">
                    <span>Muat Lebih Banyak</span>
                    <div class="nm-spinner" style="display:none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 0.8s linear infinite;"></div>
                </span>
            </center>
            <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('program_tax_load_more');
    const container = document.getElementById('program-taxonomy-container');

    if (!loadMoreBtn || !container) return;

    loadMoreBtn.addEventListener('click', function () {
        let currentPage = parseInt(loadMoreBtn.getAttribute('data-current-page'));
        const maxPages = parseInt(loadMoreBtn.getAttribute('data-max-pages'));
        const termId = loadMoreBtn.getAttribute('data-term-id');
        const nonce = loadMoreBtn.getAttribute('data-nonce');
        
        const spinner = loadMoreBtn.querySelector('.nm-spinner');
        const btnText = loadMoreBtn.querySelector('span');

        const nextPage = currentPage + 1;

        if (nextPage > maxPages) return;

        btnText.textContent = 'Memuat...';
        spinner.style.display = 'block';
        loadMoreBtn.style.pointerEvents = 'none';

        const formData = new FormData();
        formData.append('action', 'ansor_load_more_program_taxonomy');
        formData.append('page', nextPage);
        formData.append('term_id', termId);
        formData.append('nonce', nonce);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() !== '') {
                container.insertAdjacentHTML('beforeend', data);
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
        .catch(err => {
            btnText.textContent = 'Muat Lebih Banyak';
            spinner.style.display = 'none';
            loadMoreBtn.style.pointerEvents = 'auto';
        });
    });
});
</script>

<?php get_footer(); ?>