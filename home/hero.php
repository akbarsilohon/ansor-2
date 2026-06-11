<?php $option = get_option('gp_ansor', []); ?>
<section class="ansor_hero">
    <div class="container">
        <div class="hero_grid">
            <div class="hero_text">
                <span class="hero_badge">ansorpati.com</span>
                <h1 class="hero_heading"><?php echo $option['hero_heading'] ?? 'Bergerak, Berkaya, <span>Berdampak</span>'; ?></h1>
                <p class="hero_p"><?php echo $option['hero_p'] ?? 'Pimpinan cabang gerakan pemuda Ansor Kabupaten Pati. Ansor Pati hadir sebagai ruang belajar dan berkarya bagi siapa pun yang ingin meningkatkan kapasitas diri.'; ?></p>
                <a href="<?php echo $option['hero_btn_url'] ?? '#'; ?>" class="hero-btn"><?php echo $option['hero_btn'] ?? 'Mari Diskusi'; ?></a>
            </div>
            <div class="hero_image_wrapper">
                <div class="hero_image">
                    <img src="<?php echo an_fav; ?>" alt="<?php bloginfo( 'name' ); ?>">
                </div>
            </div>
        </div>
    </div>
</section>