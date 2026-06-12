<section class="ansor_visi_misi">
    <div class="container">
        <h2 class="section_heading"><span>Galeri</span> Kegiatan</h2>
        
        <?php 
        $args = array(
            'post_type'      => 'galeri',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'order'          => 'DESC',
            'orderby'        => 'date'
        );

        $galeri_query = new WP_Query($args);

        if ( $galeri_query->have_posts() ) : ?>
            <div class="ansor_galeri_grid">
                <?php while ( $galeri_query->have_posts() ) : $galeri_query->the_post(); ?>
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
                <?php endwhile; ?>
            </div>

            <?php if ( $galeri_query->max_num_pages > 1 ) { ?>
                <br><br>
                <center>
                    <a href="<?php echo home_url('galeri-all'); ?>" class="hero-btn">
                        Lihat Semua
                    </a>
                </center>
                <?php
            } ?>
        <?php else : ?>
            <center><p>Belum ada dokumentasi galeri kegiatan yang ditambahkan.</p></center>
        <?php 
        endif; 
        wp_reset_postdata(); 
        ?>
    </div>
</section>