<?php

// Admin menu Ansor Pati ======================
add_action('admin_menu', function(){
    add_menu_page( an_name, an_name, 'manage_options', 'ansor', 'ansor_root_page', an_admin_icon, 1 );
    add_submenu_page( 'ansor', 'Pengaturan Umum', 'Pengaturan Umum', 'manage_options', 'ansor', 'ansor_root_page' );
    add_submenu_page( 'ansor', 'Hero', 'Hero', 'manage_options', 'ansor_hero', 'ansor_render_hero_page' );
    add_submenu_page( 'ansor', 'Visi & Misi', 'Visi & Misi', 'manage_options', 'ansor_vm', 'ansor_render_vm_page' );
    add_submenu_page( 'ansor', 'FAQs', 'FAQs', 'manage_options', 'ansor_faqs', 'ansor_render_faqs_page' );
    add_submenu_page( 'ansor', 'Footer', 'Footer', 'manage_options', 'ansor_footer', 'ansor_render_ansor_footer_page' );
});

require_once 'pages/root.php';
require_once 'pages/hero.php';
require_once 'pages/visi-misi.php';
require_once 'pages/faqs.php';
require_once 'pages/footer.php';