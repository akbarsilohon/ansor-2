<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a href="#" class="ansor_action">Kontak Kami</a>
                <span class="menu_open">
                    <i class="fa-solid fa-bars"></i>
                </span>
            </div>
        </div>
    </header>