<?php

function ansor_register_pengurus_cpt() {
    $labels = array(
        'name'               => 'Pengurus',
        'singular_name'      => 'Pengurus',
        'menu_name'          => 'Pengurus',
        'add_new'            => 'Tambah Baru',
        'add_new_item'       => 'Tambah Pengurus Baru',
        'edit_item'          => 'Edit Data Pengurus',
        'new_item'           => 'Pengurus Baru',
        'view_item'          => 'Lihat Profil Pengurus',
        'search_items'       => 'Cari Pengurus',
        'not_found'          => 'Data Pengurus Tidak Ditemukan',
        'not_found_in_trash' => 'Data Pengurus Tidak Ditemukan di Tempat Sampah',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => false,
        'menu_icon'           => 'dashicons-businessman',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'             => array('slug' => 'pengurus'),
        'show_in_rest'        => true,
    );

    register_post_type('pengurus', $args);
}
add_action('init', 'ansor_register_pengurus_cpt');