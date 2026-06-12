<?php get_header(); ?>

<br>
<section class="ansor-mt-4rem">
    <div class="container">
        <h2 class="section_heading">Program <span>Kerja</span></h2>
        
        <div class="ansor_program_filter_box">
            <form id="ansor-program-filter-form">
                <div class="filter_input_group">
                    <div class="filter_cell">
                        <label>Kategori Program</label>
                        <select name="program_category" id="program_category">
                            <option value="all">Semua Kategori</option>
                            <?php 
                            $terms = get_terms(array(
                                'taxonomy'   => 'kategori_program',
                                'hide_empty' => true,
                            ));
                            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                                foreach ( $terms as $term ) {
                                    echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filter_cell">
                        <label>Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from">
                    </div>

                    <div class="filter_cell">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to">
                    </div>
                </div>

                <div class="filter_action_group">
                    <button type="submit" class="hero-btn">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <?php 
        $per_page = get_option('posts_per_page');
        $paged    = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        
        $args = array(
            'post_type'      => 'program_kerja',
            'posts_per_page' => $per_page,
            'post_status'    => 'publish',
            'paged'          => $paged,
            'order'          => 'DESC',
            'orderby'        => 'date'
        );

        $program_query = new WP_Query($args);
        ?>

        <div class="ansor_program_grid" id="program-post-container">
            <?php if ( $program_query->have_posts() ) : ?>
                <?php while ( $program_query->have_posts() ) : $program_query->the_post(); 
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
                <?php endwhile; ?>
            <?php else : ?>
                <center id="program-empty-msg" style="grid-column: 1/-1;"><p>Belum ada program kerja yang ditambahkan.</p></center>
            <?php endif; ?>
        </div>

        <br><br>
        <center>
            <span id="program_load_more" class="hero-btn" 
                  data-current-page="<?php echo $paged; ?>" 
                  data-max-pages="<?php echo $program_query->max_num_pages; ?>" 
                  data-nonce="<?php echo wp_create_nonce('ansor_program_nonce'); ?>" 
                  style="cursor:pointer; display: <?php echo ($program_query->max_num_pages > $paged) ? 'inline-flex' : 'none'; ?>; align-items: center; gap: 10px;">
                <span>Muat Lebih Banyak</span>
                <div class="nm-spinner" style="display:none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: #fff; animation: spin 0.8s linear infinite;"></div>
            </span>
        </center>
        <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
        <?php wp_reset_postdata(); ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('ansor-program-filter-form');
    const loadMoreBtn = document.getElementById('program_load_more');
    const container = document.getElementById('program-post-container');

    if (!filterForm || !container) return;

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        fetchFilteredPosts(1, false);
    });

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            let currentPage = parseInt(loadMoreBtn.getAttribute('data-current-page'));
            fetchFilteredPosts(currentPage + 1, true);
        });
    }

    function fetchFilteredPosts(page, isLoadMore) {
        const catValue = document.getElementById('program_category').value;
        const dateFrom = document.getElementById('date_from').value;
        const dateTo = document.getElementById('date_to').value;
        const nonce = loadMoreBtn ? loadMoreBtn.getAttribute('data-nonce') : '';
        
        const spinner = loadMoreBtn ? loadMoreBtn.querySelector('.nm-spinner') : null;
        const btnText = loadMoreBtn ? loadMoreBtn.querySelector('span') : null;

        if (isLoadMore && loadMoreBtn) {
            btnText.textContent = 'Memuat...';
            if (spinner) spinner.style.display = 'block';
            loadMoreBtn.style.pointerEvents = 'none';
        }

        const formData = new FormData();
        formData.append('action', 'ansor_filter_program_posts');
        formData.append('page', page);
        formData.append('category', catValue);
        formData.append('date_from', dateFrom);
        formData.append('date_to', dateTo);
        formData.append('nonce', nonce);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                if (isLoadMore) {
                    container.insertAdjacentHTML('beforeend', res.data.html);
                    loadMoreBtn.setAttribute('data-current-page', page);
                } else {
                    container.innerHTML = res.data.html;
                    if (loadMoreBtn) loadMoreBtn.setAttribute('data-current-page', 1);
                }

                if (loadMoreBtn) {
                    loadMoreBtn.setAttribute('data-max-pages', res.data.max_pages);
                    if (page >= res.data.max_pages || res.data.max_pages <= 1) {
                        loadMoreBtn.style.display = 'none';
                    } else {
                        loadMoreBtn.style.display = 'inline-flex';
                    }
                    
                    btnText.textContent = 'Muat Lebih Banyak';
                    if (spinner) spinner.style.display = 'none';
                    loadMoreBtn.style.pointerEvents = 'auto';
                }
            }
        })
        .catch(err => {
            if (loadMoreBtn) {
                btnText.textContent = 'Muat Lebih Banyak';
                if (spinner) spinner.style.display = 'none';
                loadMoreBtn.style.pointerEvents = 'auto';
            }
        });
    }
});
</script>

<?php get_footer(); ?>