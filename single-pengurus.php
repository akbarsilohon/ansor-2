<?php get_header(); ?>

<section class="news ansor-mt-4rem">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            $post_id      = get_the_ID();
            $jabatan      = get_post_meta($post_id, '_pengurus_jabatan', true);
            $masa_khidmat = get_post_meta($post_id, '_pengurus_masa_khidmat', true);
            $whatsapp     = get_post_meta($post_id, '_pengurus_whatsapp', true);
            $email        = get_post_meta($post_id, '_pengurus_email', true);
            $instagram    = get_post_meta($post_id, '_pengurus_instagram', true);
            $facebook     = get_post_meta($post_id, '_pengurus_facebook', true);
            $bio          = get_post_meta($post_id, '_pengurus_bio', true);
        ?>
            <div class="ansor_single_pengurus_wrapper">
                <div class="pengurus_detail_card">
                    <div class="pengurus_detail_left">
                        <div class="pengurus_big_avatar">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(an_home_icon); ?>" alt="Default Avatar">
                            <?php endif; ?>
                        </div>

                        <div class="pengurus_detail_socials">
                            <?php if ( ! empty($whatsapp) ) : ?>
                                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" class="pengurus_soc_link wa" aria-label="WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ( ! empty($instagram) ) : ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="pengurus_soc_link ig" aria-label="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ( ! empty($facebook) ) : ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="pengurus_soc_link fb" aria-label="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ( ! empty($email) ) : ?>
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="pengurus_soc_link mail" aria-label="Email">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pengurus_detail_right">
                        <span class="pengurus_detail_period">Masa Khidmat: <?php echo esc_html($masa_khidmat ? $masa_khidmat : '-'); ?></span>
                        <h1 class="pengurus_detail_name"><?php the_title(); ?></h1>
                        <h2 class="pengurus_detail_role"><?php echo esc_html($jabatan ? $jabatan : 'Fungsionaris'); ?></h2>
                        
                        <div class="pengurus_detail_divider"></div>
                        
                        <div class="pengurus_detail_bio_content">
                            <h3 class="pengurus_bio_title">Profil & Biografi</h3>
                            <?php if ( ! empty($bio) ) : ?>
                                <p><?php echo nl2br(esc_html($bio)); ?></p>
                            <?php else : ?>
                                <p>Kader pengurus aktif Pimpinan Cabang Gerakan Pemuda Ansor Kabupaten Pati yang berdedikasi tinggi dalam menjalankan amanah keorganisasian, mengawal kedaulatan ulama, serta merawat nilai-nilai Ahlussunnah wal Jamaah An-Nahdliyah di tanah Bumi Mina Tani.</p>
                            <?php endif; ?>
                        </div>

                        <div class="pengurus_detail_body_text">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>


        <?php 
        $current_pengurus_id = get_the_ID();
        $other_pengurus_args = array(
            'post_type'      => 'pengurus',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'post__not_in'   => array($current_pengurus_id),
            'orderby'        => 'rand'
        );

        $other_pengurus_query = new WP_Query($other_pengurus_args);

        if( $other_pengurus_query->have_posts() ){ ?>
            <h2 class="section_heading">Pengurus <span>Lainnya</span></h2>
            <div class="pengurus_round_display">
                <?php while( $other_pengurus_query->have_posts()){
                    $other_pengurus_query->the_post();
                    $post_id = get_the_ID();
                    $jabatan = get_post_meta($post_id, '_pengurus_jabatan', true); ?>
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
                    <?php
                } ?>
            </div>
        <?php
        }

        wp_reset_postdata();
        ?>
    </div>
</section>

<?php get_footer(); ?>