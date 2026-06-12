<section class="ansor-mt-4rem">
    <div class="container">
        <h2 class="section_heading">Program <span>Kerja</span></h2>
        
        <?php 
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        
        $args = array(
            'post_type'      => 'program_kerja',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'paged'          => $paged,
            'order'          => 'DESC',
            'orderby'        => 'date'
        );

        $program_query = new WP_Query($args);

        if ( $program_query->have_posts() ) : ?>
            <div class="ansor_program_grid">
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
            </div>
            
            <?php 
            echo paginate_links(array(
                'total'   => $program_query->max_num_pages,
                'current' => $paged,
                'type'    => 'list',
                'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
            ));
            ?>
        <?php else : ?>
            <center><p>Belum ada program kerja yang ditambahkan.</p></center>
        <?php 
        endif; 
        wp_reset_postdata(); 
        ?>
    </div>
</section>