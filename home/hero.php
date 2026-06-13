<?php $option = get_option('gp_ansor', []); ?>
<section class="ansor_hero">
    <div class="container">
        <div class="hero_grid">
            <div class="hero_text">
                <span class="hero_badge">
                    <?php 
                    $default_domain = wp_parse_url( home_url(), PHP_URL_HOST );
                    $badge = isset($option['text_badge']) && !empty($option['text_badge']) ? $option['text_badge'] : $default_domain;

                    echo esc_html( $badge );
                    ?>
                </span>
                <h1 class="hero_heading">
                    <?php
                    $defaultHeading = 'Bergerak, Berkaya, <span>Berdampak</span>';
                    $heading = isset($option['hero_heading']) && !empty($option['hero_heading']) ? $option['hero_heading'] : $defaultHeading;

                    echo $heading;
                    ?>
                </h1>
                <p class="hero_p">
                    <?php 
                    $defDesc = 'Pimpinan cabang gerakan pemuda Ansor Kabupaten Pati. Ansor Pati hadir sebagai ruang belajar dan berkarya bagi siapa pun yang ingin meningkatkan kapasitas diri.';
                    $heroDesc = isset($option['hero_desc']) && !empty($option['hero_desc']) ? $option['hero_desc'] : $defDesc;

                    echo esc_attr( $heroDesc );
                    ?>
                </p>
                <?php 
                $heroText = isset($option['her_text_action']) && !empty($option['her_text_action']) ? $option['her_text_action'] : 'Mari Diskusi';
                $heroUri = isset($option['hero_url_action']) && !empty($option['hero_url_action']) ? $option['hero_url_action'] : '#';
                ?>
                <a href="<?php echo esc_url( $heroUri ); ?>" class="hero-btn"><?php echo esc_attr( $heroText ); ?></a>
            </div>
            <div class="hero_image_wrapper">
                <div class="hero_image">
                    <img src="<?php echo $option['hero_image'] ?? an_fav; ?>" alt="<?php bloginfo( 'name' ); ?>">
                </div>
            </div>
        </div>
    </div>
</section>