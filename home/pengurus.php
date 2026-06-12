<section class="ansor-mt-4rem">
    <div class="container">
        <h2 class="section_heading">Struktur <span>Pengurus</span></h2>
        <?php 
        $args = array(
            'post_type'      => 'pengurus',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'order'          => 'ASC',
            'orderby'        => 'menu_order'
        );

        $pengurus_query = new WP_Query($args);

        if( $pengurus_query->have_posts()){ ?>
            <div class="pengurus_round_display">
                <?php while ( $pengurus_query->have_posts() ) : $pengurus_query->the_post(); 
                    $post_id = get_the_ID();
                    $jabatan = get_post_meta($post_id, '_pengurus_jabatan', true);
                ?>
                    <div class="pengurus_round_item">
                        <a href="<?php the_permalink(); ?>" class="pengurus_round_avatar">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('thumbnail', array('loading' => 'lazy')); ?>
                            <?php else : ?>
                                <div class="pengurus_round_placeholder">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                        
                        <div class="pengurus_round_details">
                            <span class="p_round_jabatan"><?php echo esc_html($jabatan); ?></span>
                            <h3 class="p_round_name">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        }

        wp_reset_postdata();
        ?>
    </div>
</section>