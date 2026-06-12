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


function ansor_add_program_kerja_meta_boxes() {
    add_meta_box(
        'program_kerja_details',
        'Detail Informasi Program Kerja',
        'ansor_render_program_kerja_meta_box',
        'program_kerja',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'ansor_add_program_kerja_meta_boxes');

function ansor_render_program_kerja_meta_box($post) {
    wp_nonce_field('ansor_save_program_kerja_meta', 'ansor_program_kerja_meta_nonce');

    $status       = get_post_meta($post->ID, '_program_status', true);
    $waktu        = get_post_meta($post->ID, '_program_waktu', true);
    $pelaksana    = get_post_meta($post->ID, '_program_pelaksana', true);
    $target       = get_post_meta($post->ID, '_program_target', true);
    $lokasi       = get_post_meta($post->ID, '_program_lokasi', true);
    $file_url     = get_post_meta($post->ID, '_program_file_url', true);
    ?>
    <div class="gritemp">
        <div class="form-group-meta">
            <label for="program_status">Status Program</label>
            <select id="program_status" name="program_status" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #8c8f94;">
                <option value="Planned" <?php selected($status, 'Planned'); ?>>Direncanakan</option>
                <option value="In Progress" <?php selected($status, 'In Progress'); ?>>Sedang Berjalan</option>
                <option value="Completed" <?php selected($status, 'Completed'); ?>>Selesai</option>
                <option value="Routine" <?php selected($status, 'Routine'); ?>>Terealisasi Berkala</option>
            </select>
        </div>

        <div class="form-group-meta">
            <label for="program_waktu">Waktu Pelaksanaan</label>
            <input type="text" id="program_waktu" name="program_waktu" value="<?php echo esc_attr($waktu); ?>" placeholder="Contoh: 15 Agustus 2026 / Triwulan I">
        </div>

        <div class="form-group-meta">
            <label for="program_pelaksana">Penanggung Jawab / Pelaksana</label>
            <input type="text" id="program_pelaksana" name="program_pelaksana" value="<?php echo esc_attr($pelaksana); ?>" placeholder="Contoh: Bidang Rijalul Ansor">
        </div>

        <div class="form-group-meta">
            <label for="program_target">Target Peserta</label>
            <input type="text" id="program_target" name="program_target" value="<?php echo esc_attr($target); ?>" placeholder="Contoh: Seluruh Kader Ranting Ansor">
        </div>

        <div class="form-group-meta">
            <label for="program_lokasi">Lokasi Kegiatan</label>
            <input type="text" id="program_lokasi" name="program_lokasi" value="<?php echo esc_attr($lokasi); ?>" placeholder="Contoh: Aula Gedung PCNU Pati">
        </div>

        <div class="form-group-meta">
            <label for="program_file_url">Link Dokumen / Lampiran (PDF)</label>
            <input type="url" id="program_file_url" name="program_file_url" value="<?php echo esc_url($file_url); ?>" placeholder="Contoh: https://link-download-proposal-atau-laporan">
        </div>
    </div>
    <?php
}

function ansor_save_program_kerja_meta($post_id) {
    if (!isset($_POST['ansor_program_kerja_meta_nonce']) || !wp_verify_nonce($_POST['ansor_program_kerja_meta_nonce'], 'ansor_save_program_kerja_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
        'program_status'    => '_program_status',
        'program_waktu'     => '_program_waktu',
        'program_pelaksana' => '_program_pelaksana',
        'program_target'    => '_program_target',
        'program_lokasi'    => '_program_lokasi',
        'program_file_url'  => '_program_file_url',
    ];

    foreach ($fields as $input_name => $meta_key) {
        if (isset($_POST[$input_name])) {
            $value = ($input_name === 'program_file_url') ? esc_url_raw($_POST[$input_name]) : sanitize_text_field($_POST[$input_name]);
            update_post_meta($post_id, $meta_key, $value);
        }
    }
}
add_action('save_post', 'ansor_save_program_kerja_meta');