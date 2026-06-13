<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yeseva+One&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php $option = get_option('gp_ansor', []); ?>
    <header class="header <?= is_home() ? 'transparant' : ''; ?>" id="anshor_header">
        <div class="inside-header">
            <div class="site-logo">
                <a href="<?php bloginfo( 'url' ); ?>">
                    <?php $logo = isset($option['logo']) && !empty($option['logo']) ? $option['logo'] : an_logo; ?>
                    <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="ansor_brand">
                </a>
            </div>

            <div class="left-wrapper">
                <?php wp_nav_menu(
                        array(
                            'theme_location'        =>  'primary',
                            'container'             =>  false,
                            'menu_class'            =>  'ansor_primary',
                            'menu_id'               =>  'ansor_primary'
                        )
                    ); ?>
            </div>
            <div class="hide_destop">
                <?php 
                $btnText = isset( $option['btn_header_text']) && !empty($option['btn_header_text']) ? $option['btn_header_text'] : 'Konta Kami';
                $btnUrl = isset( $option['btn_header_url']) && !empty($option['btn_header_url']) ? $option['btn_header_url'] : '#';
                ?>
                <a href="<?php echo esc_url( $btnUrl ); ?>" class="ansor_action"><?php echo esc_html( $btnText ); ?></a>
                <span class="menu_open">
                    <i class="fa-solid fa-bars"></i>
                </span>
            </div>
        </div>
    </header>