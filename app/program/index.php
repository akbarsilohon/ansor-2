<?php

function ansor_register_program_kerja_dan_kategori() {
    $labels_cpt = array(
        'name'               => 'Program Kerja',
        'singular_name'      => 'Program Kerja',
        'menu_name'          => 'Program Kerja',
        'add_new'            => 'Tambah Baru',
        'add_new_item'       => 'Tambah Program Kerja Baru',
        'edit_item'          => 'Edit Program Kerja',
        'new_item'           => 'Program Kerja Baru',
        'view_item'          => 'Lihat Program Kerja',
        'search_items'       => 'Cari Program Kerja',
        'not_found'          => 'Program Kerja Tidak Ditemukan',
        'not_found_in_trash' => 'Program Kerja Tidak Ditemukan di Tempat Sampah',
    );

    $args_cpt = array(
        'labels'              => $labels_cpt,
        'public'              => true,
        'has_archive'         => true,
        'menu_icon'           => 'dashicons-clipboard',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'             => array('slug' => 'program-kerja'),
        'show_in_rest'        => true,
    );

    register_post_type('program_kerja', $args_cpt);

    $labels_tax = array(
        'name'              => 'Kategori Program',
        'singular_name'     => 'Kategori Program',
        'search_items'      => 'Cari Kategori',
        'all_items'         => 'Semua Kategori',
        'parent_item'       => 'Kategori Induk',
        'parent_item_colon' => 'Kategori Induk:',
        'edit_item'         => 'Edit Kategori',
        'update_item'       => 'Perbarui Kategori',
        'add_new_item'      => 'Tambah Kategori Baru',
        'new_item_name'     => 'Nama Kategori Baru',
        'menu_name'         => 'Kategori Program',
    );

    $args_tax = array(
        'hierarchical'      => true,
        'labels'            => $labels_tax,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'kategori-program'),
        'show_in_rest'      => true,
    );

    register_taxonomy('kategori_program', array('program_kerja'), $args_tax);
}
add_action('init', 'ansor_register_program_kerja_dan_kategori');