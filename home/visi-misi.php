<?php 
$option = get_option('gp_ansor', []); 
$misi_subtitle  = $option['misi_subtitle'] ?? 'Misi Kami';
$misi_title     = $option['misi_title'] ?? 'Misi Kami, Ansor Pati';
$misi_deskripsi = $option['misi_deskripsi'] ?? '';

$visi_subtitle  = $option['visi_subtitle'] ?? 'Visi Kami';
$visi_items     = $option['visi_items'] ?? [];
?>

<section class="ansor_visi_misi">
    <div class="container">
        <h2 class="section_heading">Visi & <span>Misi</span></h2><br>
        <div class="grid_visi">
            <div class="item_misi">
                <span class="hero_badge text-hitam"><?php echo esc_html( $misi_subtitle ); ?></span>
                <h1 class="hero_heading"><?php echo wp_kses_post( $misi_title ); ?></h1>
                <p class="hero_p"><?php echo nl2br( esc_html( $misi_deskripsi ) ); ?></p>
            </div>
            <div class="item_visi">
                <span class="hero_badge text-hitam"><?php echo esc_html( $visi_subtitle ); ?></span>
                <div class="gAboutList">
                    <?php 
                    if ( ! empty( $visi_items ) && is_array( $visi_items ) ) : 
                        foreach ( $visi_items as $visi ) : 
                    ?>
                        <div class="gAboutPoint">
                            <i class="fa-solid fa-check"></i>
                            <p><?php echo esc_html( $visi ); ?></p>
                        </div>
                    <?php 
                        endforeach; 
                    else :
                        ?>
                        <div class="gAboutPoint">
                            <i class="fa-solid fa-check"></i>
                            <p>Belum ada poin visi yang dimasukkan.</p>
                        </div>
                        <?php 
                    endif; 
                    ?>

                </div>
            </div>

        </div>
    </div>
</section>