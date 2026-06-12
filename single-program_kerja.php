<?php get_header(); ?>

<section class="ansor-mt-4rem">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            $post_id   = get_the_ID();
            $status    = get_post_meta($post_id, '_program_status', true);
            $waktu     = get_post_meta($post_id, '_program_waktu', true);
            $pelaksana = get_post_meta($post_id, '_program_pelaksana', true);
            $target    = get_post_meta($post_id, '_program_target', true);
            $lokasi    = get_post_meta($post_id, '_program_lokasi', true);
            $file_url  = get_post_meta($post_id, '_program_file_url', true);
            
            $terms = get_the_terms($post_id, 'kategori_program');
            $kategori_name = ($terms && ! is_wp_error($terms)) ? $terms[0]->name : 'Umum';

            $status_label = 'Direncanakan';
            $status_class = 'planned';
            if ($status === 'In Progress') { $status_label = 'Berjalan'; $status_class = 'progress'; }
            elseif ($status === 'Completed') { $status_label = 'Selesai'; $status_class = 'completed'; }
            elseif ($status === 'Routine') { $status_label = 'Berkala'; $status_class = 'routine'; }
        ?>
            <article id="program-single-<?php the_ID(); ?>" class="ansor_single_program_container">
                
                <div class="program_single_hero">
                    <div class="program_hero_badge_group">
                        <span class="program_hero_cat"><?php echo esc_html($kategori_name); ?></span>
                        <span class="program_hero_status <?php echo $status_class; ?>"><?php echo esc_html($status_label); ?></span>
                    </div>
                    <h1 class="program_single_title"><?php the_title(); ?></h1>
                </div>

                <div class="program_single_layout_grid">
                    
                    <div class="program_content_main_side">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="program_single_main_thumb">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="program_single_rich_text">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="program_info_sidebar_side">
                        <div class="program_sticky_info_card">
                            <h3 class="info_card_heading">Detail Pelaksanaan</h3>
                            
                            <div class="info_card_row">
                                <div class="info_card_icon"><i class="fa-solid fa-calendar-day"></i></div>
                                <div class="info_card_text">
                                    <label>Waktu</label>
                                    <span><?php echo esc_html($waktu ? $waktu : '-'); ?></span>
                                </div>
                            </div>

                            <div class="info_card_row">
                                <div class="info_card_icon"><i class="fa-solid fa-location-dot"></i></div>
                                <div class="info_card_text">
                                    <label>Lokasi / Tempat</label>
                                    <span><?php echo esc_html($lokasi ? $lokasi : '-'); ?></span>
                                </div>
                            </div>

                            <div class="info_card_row">
                                <div class="info_card_icon"><i class="fa-solid fa-users-gear"></i></div>
                                <div class="info_card_text">
                                    <label>Pelaksana / Bidang</label>
                                    <span><?php echo esc_html($pelaksana ? $pelaksana : '-'); ?></span>
                                </div>
                            </div>

                            <div class="info_card_row">
                                <div class="info_card_icon"><i class="fa-solid fa-bullseye"></i></div>
                                <div class="info_card_text">
                                    <label>Target Sasaran</label>
                                    <span><?php echo esc_html($target ? $target : '-'); ?></span>
                                </div>
                            </div>

                            <?php if ( ! empty($file_url) ) : ?>
                                <div class="info_card_divider"></div>
                                <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="hero-btn download_program_btn" style="background-color: #056647; margin-bottom: 10px;">
                                    <i class="fa-solid fa-file-arrow-down"></i> Berkas Lampiran
                                </a>
                            <?php endif; ?>

                            <div class="info_card_divider"></div>

                            <a href="https://wa.me/?text=<?php echo urlencode('Ikuti perkembangan program kerja: ' . get_the_title() . ' di ' . get_permalink()); ?>" target="_blank" class="hero-btn share_program_btn">
                                <i class="fa-solid fa-share-nodes"></i> Bagikan Kegiatan
                            </a>
                        </div>
                    </div>

                </div>

            </article>
        <?php endwhile; endif; ?>
    </div>
</section>

<?php get_footer(); ?>