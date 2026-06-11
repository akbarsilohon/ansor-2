<?php

function ansor_register_galeri_cpt() {
    $labels = array(
        'name'               => 'Galeri',
        'singular_name'      => 'Galeri',
        'menu_name'          => 'Galeri',
        'add_new'            => 'Tambah Baru',
        'add_new_item'       => 'Tambah Galeri Baru',
        'edit_item'          => 'Edit Galeri',
        'new_item'           => 'Galeri Baru',
        'view_item'          => 'Lihat Galeri',
        'search_items'       => 'Cari Galeri',
        'not_found'          => 'Galeri Tidak Ditemukan',
        'not_found_in_trash' => 'Galeri Tidak Ditemukan di Tempat Sampah',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'menu_icon'           => 'dashicons-images-alt2',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'             => array('slug' => 'galeri'),
        'show_in_rest'        => true,
    );

    register_post_type('galeri', $args);
}
add_action('init', 'ansor_register_galeri_cpt');