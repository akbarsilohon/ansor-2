<?php

function ansor_register_pengurus_cpt() {
    $labels = array(
        'name'               => 'Pengurus',
        'singular_name'      => 'Pengurus',
        'menu_name'          => 'Pengurus',
        'add_new'            => 'Tambah Baru',
        'add_new_item'       => 'Tambah Pengurus',
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
        'supports'            => array('title', 'thumbnail'),
        'rewrite'             => array('slug' => 'pengurus'),
        'show_in_rest'        => true,
    );

    register_post_type('pengurus', $args);
}
add_action('init', 'ansor_register_pengurus_cpt');


// Meta Box ================================
add_action( 'add_meta_boxes', 'add_meta_boxes_for_pengurus' );
function add_meta_boxes_for_pengurus(){
    add_meta_box( 
        'pengurus_details', 
        'Informasi Detail Pengurus', 
        'ansor_render_pengurus_meta_box', 
        'pengurus', 
        'normal', 
        'high'
    );
}

// render meta boxes pengurus =====================
function ansor_render_pengurus_meta_box( $post ){
    wp_nonce_field('ansor_save_pengurus_meta', 'ansor_pengurus_meta_nonce');
    $jabatan      = get_post_meta($post->ID, '_pengurus_jabatan', true);
    $masa_khidmat = get_post_meta($post->ID, '_pengurus_masa_khidmat', true);
    $whatsapp     = get_post_meta($post->ID, '_pengurus_whatsapp', true);
    $email        = get_post_meta($post->ID, '_pengurus_email', true);
    $instagram    = get_post_meta($post->ID, '_pengurus_instagram', true);
    $facebook     = get_post_meta($post->ID, '_pengurus_facebook', true);
    $bio          = get_post_meta($post->ID, '_pengurus_bio', true); ?>

    <div class="gritemp">
        <div class="form-group-meta">
            <label for="pengurus_jabatan">Jabatan Struktural</label>
            <input type="text" id="pengurus_jabatan" name="pengurus_jabatan" value="<?php echo esc_attr($jabatan); ?>" placeholder="Contoh: Pimpinan Cabang" required />
        </div>

        <div class="form-group-meta">
            <label for="pengurus_masa_khidmat">Periode</label>
            <input type="text" id="pengurus_masa_khidmat" name="pengurus_masa_khidmat" value="<?php echo esc_attr($masa_khidmat); ?>" placeholder="Contoh: 2024 - 2028">
        </div>

        <div class="form-group-meta">
            <label for="pengurus_whatsapp">Nomor WhatsApp</label>
            <input type="text" id="pengurus_whatsapp" name="pengurus_whatsapp" value="<?php echo esc_attr($whatsapp); ?>" placeholder="Contoh: 081234567xxx">
        </div>

        <div class="form-group-meta">
            <label for="pengurus_email">Alamat Email</label>
            <input type="email" id="pengurus_email" name="pengurus_email" value="<?php echo esc_attr($email); ?>" placeholder="Contoh: nama@ansorpati.com">
        </div>

        <div class="form-group-meta">
            <label for="pengurus_instagram">Link Profil Instagram</label>
            <input type="url" id="pengurus_instagram" name="pengurus_instagram" value="<?php echo esc_url($instagram); ?>" placeholder="Contoh: https://instagram.com/username">
        </div>

        <div class="form-group-meta">
            <label for="pengurus_facebook">Link Profil Facebook</label>
            <input type="url" id="pengurus_facebook" name="pengurus_facebook" value="<?php echo esc_url($facebook); ?>" placeholder="Url profile facebook">
        </div>

        <div class="form-group-meta full-width">
            <label for="pengurus_bio">Tentang Pengurus</label>
            <textarea name="pengurus_bio" id="pengurus_bio"><?php echo esc_textarea( $bio ); ?></textarea>
        </div>
    </div>
    <?php
}

function ansor_save_pengurus_meta( $post_id ){
    if (!isset($_POST['ansor_pengurus_meta_nonce']) || !wp_verify_nonce($_POST['ansor_pengurus_meta_nonce'], 'ansor_save_pengurus_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
        'pengurus_jabatan'      => '_pengurus_jabatan',
        'pengurus_masa_khidmat' => '_pengurus_masa_khidmat',
        'pengurus_whatsapp'     => '_pengurus_whatsapp',
        'pengurus_email'        => '_pengurus_email',
        'pengurus_instagram'    => '_pengurus_instagram',
        'pengurus_facebook'     => '_pengurus_facebook',
        'pengurus_bio'          => '_pengurus_bio',
    ];
    
    foreach ($fields as $input_name => $meta_key) {
        if (isset($_POST[$input_name])) {
            switch ($input_name) {
                case 'pengurus_email':
                    $value = sanitize_email($_POST[$input_name]);
                    break;
                    
                case 'pengurus_instagram':
                case 'pengurus_facebook':
                    $value = esc_url_raw($_POST[$input_name]);
                    break;
                    
                case 'pengurus_bio':
                    $value = sanitize_textarea_field($_POST[$input_name]);
                    break;
                    
                default:
                    $value = sanitize_text_field($_POST[$input_name]);
                    break;
            }
            
            update_post_meta($post_id, $meta_key, $value);
        }
    }
}
add_action('save_post', 'ansor_save_pengurus_meta');