<?php
$option = get_option('gp_ansor', []);

$f_c1_title    = $option['footer_c1_title'] ?? 'Kantor Manajemen';
$f_address     = $option['footer_address'] ?? 'Kompleks Gedung PCNU Kabupaten Pati, Jalan Dr. Susanto No. 11, Pati, Jawa Tengah.';
$f_hours_label = $option['footer_hours_label'] ?? 'Jam Kantor';
$f_hours_val   = $option['footer_hours_val'] ?? 'Senin - Jumat 07.30 - 17.00 WIB';

$f_c2_title    = $option['footer_c2_title'] ?? 'Official Kontak';
$f_phone       = $option['footer_phone'] ?? '';
$f_email       = $option['footer_email'] ?? '';
$f_wa          = $option['footer_wa'] ?? '';

$f_c3_title    = $option['footer_c3_title'] ?? 'Navigasi';
$f_nav_items   = $option['footer_nav_items'] ?? [];

$f_c4_title    = $option['footer_c4_title'] ?? 'Ikuti Kami';
$f_social_desc = $option['footer_social_desc'] ?? 'Silahkan follow akun media sosial kami untuk info terbaru';
$soc_fb        = $option['soc_fb'] ?? '';
$soc_ig        = $option['soc_ig'] ?? '';
$soc_yt        = $option['soc_yt'] ?? '';
$soc_tw        = $option['soc_tw'] ?? '';

$f_copyright   = $option['footer_copyright'] ?? 'Copyright &copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All Rights Reserved.';
?>

<footer class="site_footer">
    <div class="container">
        <div class="footer_grid">
            
            <div class="footer_col">
                <h3 class="footer_title"><?php echo esc_html( $f_c1_title ); ?></h3>
                <p class="footer_text"><?php echo nl2br( esc_html( $f_address ) ); ?></p>
                
                <?php if ( ! empty( $f_hours_val ) ) : ?>
                    <div class="footer_info_block">
                        <span class="info_label"><?php echo esc_html( $f_hours_label ); ?></span>
                        <p class="footer_text"><?php echo esc_html( $f_hours_val ); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer_col">
                <h3 class="footer_title"><?php echo esc_html( $f_c2_title ); ?></h3>
                <ul class="footer_links">
                    
                    <?php if ( ! empty( $f_phone ) ) : ?>
                        <li>
                            <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $f_phone) ); ?>">
                                <i class="fa-solid fa-phone"></i>
                                <?php echo esc_html( $f_phone ); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ( ! empty( $f_email ) ) : ?>
                        <li>
                            <a href="mailto:<?php echo esc_attr( $f_email ); ?>">
                                <i class="fa-solid fa-envelope"></i>
                                <?php echo esc_html( $f_email ); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ( ! empty( $f_wa ) ) : ?>
                        <li>
                            <?php 
                            $wa_url = ( filter_var($f_wa, FILTER_VALIDATE_URL) ) ? $f_wa : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $f_wa);
                            ?>
                            <a href="<?php echo esc_url( $wa_url ); ?>" target="_blank">
                                <i class="fa-brands fa-whatsapp"></i>
                                WhatsApp Kontak
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

            <div class="footer_col">
                <h3 class="footer_title"><?php echo esc_html( $f_c3_title ); ?></h3>
                <ul class="footer_links">
                    <?php 
                    if ( ! empty( $f_nav_items ) && is_array( $f_nav_items ) ) : 
                        foreach ( $f_nav_items as $nav ) : 
                            $text = $nav['text'] ?? '';
                            $url  = $nav['url'] ?? '#';
                            if ( empty( $text ) ) continue;
                    ?>
                        <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $text ); ?></a></li>
                    <?php 
                        endforeach; 
                    else : 
                        ?>
                        <li><a href="#">Laporan & Publikasi</a></li>
                        <li><a href="#">Berita</a></li>
                        <li><a href="#">Relawan</a></li>
                        <?php 
                    endif; 
                    ?>
                </ul>
            </div>

            <div class="footer_col">
                <h3 class="footer_title"><?php echo esc_html( $f_c4_title ); ?></h3>
                <p class="footer_text_alt"><?php echo esc_html( $f_social_desc ); ?></p>
                <div class="footer_socials">
                    
                    <?php if ( ! empty( $soc_fb ) ) : ?>
                        <a href="<?php echo esc_url( $soc_fb ); ?>" class="social_icon facebook" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <?php endif; ?>

                    <?php if ( ! empty( $soc_ig ) ) : ?>
                        <a href="<?php echo esc_url( $soc_ig ); ?>" class="social_icon instagram" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>

                    <?php if ( ! empty( $soc_yt ) ) : ?>
                        <a href="<?php echo esc_url( $soc_yt ); ?>" class="social_icon youtube" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <?php endif; ?>

                    <?php if ( ! empty( $soc_tw ) ) : ?>
                        <a href="<?php echo esc_url( $soc_tw ); ?>" class="social_icon threads" target="_blank"><i class="fa-brands fa-threads"></i></a>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <div class="footer_bottom">
        <div class="container">
            <p><?php echo wp_kses_post( $f_copyright ); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>