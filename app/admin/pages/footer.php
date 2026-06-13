<?php

function ansor_render_ansor_footer_page(){
    $option = get_option('gp_ansor', []); ?>
    
    <?php if (isset($_GET['saved'])): ?>
        <div class="updated notice is-dismissible"><p><strong>Pengaturan Footer berhasil disimpan!</strong></p></div>
    <?php endif; ?>

    <div class="ansor_container">
        <div class="ansor_heading">
            <div class="ansor_brand_flex">
                <div class="inline_img">
                    <img src="<?php echo esc_url( an_fav ); ?>" alt="<?php echo an_name; ?>" class="ansor-admin-logo">
                </div>
                <div class="ansor_title_wrapper">
                    <h1><?php echo an_name; ?></h1>
                    <p>Beauty, Responsive, Premium Magazine & Organization WordPress Theme</p>
                </div>
            </div>
            <div class="ansor_ver"><span>Version <?php echo an_ver; ?></span></div>
            <div class="ansor_nav">
                <a href="<?php echo admin_url('admin.php?page=ansor'); ?>" class="ansor_nav-uri">Pengaturan Umum</a>
                <a href="<?php echo admin_url('admin.php?page=ansor_hero'); ?>" class="ansor_nav-uri">Hero</a>
                <a href="<?php echo admin_url('admin.php?page=ansor_vm'); ?>" class="ansor_nav-uri">Visi & Misi</a>
                <a href="<?php echo admin_url('admin.php?page=ansor_faqs'); ?>" class="ansor_nav-uri">FAQs</a>
                <a href="<?php echo admin_url('admin.php?page=ansor_footer'); ?>" class="ansor_nav-uri active">Footer</a>
            </div>
        </div>

        <form method="post" action="<?php echo admin_url('admin.php?page=ansor_footer'); ?>" class="ansor_body">
            
            <?php wp_nonce_field( 'ansor_footer_save_action', 'ansor_footer_nonce_field' ); ?>

            <span class="ansor_section-title">Konfigurasi Footer Website</span>

            <div class="form-grid" style="margin-top: 20px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
                
                <div class="form-col">
                    <h3 style="border-bottom: 2px solid #487E50; padding-bottom: 5px;">Kolom 1: Kantor Manajemen</h3>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Judul Kolom</label>
                        <input type="text" name="gp_ansor[footer_c1_title]" value="<?php echo esc_attr($option['footer_c1_title'] ?? 'Kantor Manajemen'); ?>" />
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Alamat Lengkap</label>
                        <textarea name="gp_ansor[footer_address]" class="ansor_text_area" style="min-height: 80px;"><?php echo esc_textarea($option['footer_address'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Label Jam Kantor</label>
                        <input type="text" name="gp_ansor[footer_hours_label]" value="<?php echo esc_attr($option['footer_hours_label'] ?? 'Jam Kantor'); ?>" />
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Detail Jam</label>
                        <input type="text" name="gp_ansor[footer_hours_val]" value="<?php echo esc_attr($option['footer_hours_val'] ?? ''); ?>" />
                    </div>
                </div>

                <div class="form-col">
                    <h3 style="border-bottom: 2px solid #487E50; padding-bottom: 5px;">Kolom 2: Official Kontak</h3>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Judul Kolom</label>
                        <input type="text" name="gp_ansor[footer_c2_title]" value="<?php echo esc_attr($option['footer_c2_title'] ?? 'Official Kontak'); ?>" />
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Nomor Telepon</label>
                        <input type="text" name="gp_ansor[footer_phone]" value="<?php echo esc_attr($option['footer_phone'] ?? ''); ?>" />
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Email Resmi</label>
                        <input type="email" name="gp_ansor[footer_email]" value="<?php echo esc_attr($option['footer_email'] ?? ''); ?>" />
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Link/Nomor WhatsApp</label>
                        <input type="text" name="gp_ansor[footer_wa]" value="<?php echo esc_attr($option['footer_wa'] ?? ''); ?>" />
                    </div>
                </div>

                <div class="form-col">
                    <h3 style="border-bottom: 2px solid #487E50; padding-bottom: 5px;">Kolom 3: Navigasi</h3>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Judul Kolom</label>
                        <input type="text" name="gp_ansor[footer_c3_title]" value="<?php echo esc_attr($option['footer_c3_title'] ?? 'Navigasi'); ?>" />
                    </div>
                    
                    <div class="form-group" style="margin-top: 15px;">
                        <label style="margin-bottom: 8px; display: block;">Link Navigasi Menu</label>
                        
                        <div id="nav-dynamic-container" style="display: flex; flex-direction: column; gap: 10px;">
                            <?php 
                            $nav_list = $option['footer_nav_items'] ?? [ ['text' => '', 'url' => ''] ]; 
                            foreach ( $nav_list as $index => $nav_item ) : 
                                $nav_text = $nav_item['text'] ?? '';
                                $nav_url  = $nav_item['url'] ?? '';
                            ?>
                                <div class="nav-item-row" style="display: flex; gap: 8px; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; border-radius: 6px;">
                                    <input type="text" name="gp_ansor[footer_nav_items][<?php echo $index; ?>][text]" value="<?php echo esc_attr($nav_text); ?>" placeholder="Nama Menu (ex: Beranda)" style="flex: 1; min-width: 0;" />
                                    <input type="text" name="gp_ansor[footer_nav_items][<?php echo $index; ?>][url]" value="<?php echo esc_attr($nav_url); ?>" placeholder="URL Link (ex: https://...)" style="flex: 1; min-width: 0;" />
                                    <button type="button" class="btn-action hapus remove-nav-row" style="padding: 10px; cursor: pointer; line-height: 1;">Hapus</button>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="button" id="add-nav-row" class="btn-action ganti" style="margin-top: 12px; padding: 8px 15px; cursor: pointer; width: max-content; font-size: 13px;">
                            + Tambah Menu Link
                        </button>
                    </div>
                </div>

                <div class="form-col">
                    <h3 style="border-bottom: 2px solid #487E50; padding-bottom: 5px;">Kolom 4: Ikuti Kami</h3>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Judul Kolom</label>
                        <input type="text" name="gp_ansor[footer_c4_title]" value="<?php echo esc_attr($option['footer_c4_title'] ?? 'Ikuti Kami'); ?>" />
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Deskripsi Singkat</label>
                        <textarea name="gp_ansor[footer_social_desc]" class="ansor_text_area" style="min-height: 60px;"><?php echo esc_textarea($option['footer_social_desc'] ?? ''); ?></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                        <div class="form-group"><label>Facebook Link</label><input type="text" name="gp_ansor[soc_fb]" value="<?php echo esc_attr($option['soc_fb'] ?? ''); ?>" /></div>
                        <div class="form-group"><label>Instagram Link</label><input type="text" name="gp_ansor[soc_ig]" value="<?php echo esc_attr($option['soc_ig'] ?? ''); ?>" /></div>
                        <div class="form-group"><label>Youtube Link</label><input type="text" name="gp_ansor[soc_yt]" value="<?php echo esc_attr($option['soc_yt'] ?? ''); ?>" /></div>
                        <div class="form-group"><label>Twitter/X Link</label><input type="text" name="gp_ansor[soc_tw]" value="<?php echo esc_attr($option['soc_tw'] ?? ''); ?>" /></div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #E2E8F0;">
                <div class="form-group">
                    <label>Teks Copyright (Footer Paling Bawah)</label>
                    <input type="text" name="gp_ansor[footer_copyright]" 
                           value="<?php echo esc_attr($option['footer_copyright'] ?? 'Copyright © ' . date('Y') . ' ' . get_bloginfo('name') . '. All Rights Reserved.'); ?>" 
                           style="max-width: 100%;" />
                </div>
            </div>

            <div class="ansor_action" style="margin-top: 30px;">
                <input type="hidden" name="ansor_footer_submit" value="1" />
                <button type="submit" class="ansor_button">Simpan Footer</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navContainer = document.getElementById('nav-dynamic-container');
            const addNavButton = document.getElementById('add-nav-row');
            addNavButton.addEventListener('click', function() {
                const uniqueIndex = Date.now();
                const newRow = document.createElement('div');
                newRow.className = 'nav-item-row';
                newRow.style.display = 'flex';
                newRow.style.gap = '8px';
                newRow.style.alignItems = 'center';
                newRow.style.background = '#f8fafc';
                newRow.style.border = '1px solid #e2e8f0';
                newRow.style.padding = '10px';
                newRow.style.borderRadius = '6px';

                newRow.innerHTML = `
                    <input type="text" name="gp_ansor[footer_nav_items][${uniqueIndex}][text]" value="" placeholder="Nama Menu (ex: Beranda)" style="flex: 1; min-width: 0;" />
                    <input type="text" name="gp_ansor[footer_nav_items][${uniqueIndex}][url]" value="" placeholder="URL Link (ex: https://...)" style="flex: 1; min-width: 0;" />
                    <button type="button" class="btn-action hapus remove-nav-row" style="padding: 10px; cursor: pointer; line-height: 1;">Hapus</button>
                `;
                navContainer.appendChild(newRow);
            });

            navContainer.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-nav-row')) {
                    const row = e.target.closest('.nav-item-row');
                    const allRows = navContainer.querySelectorAll('.nav-item-row');
                    if (allRows.length > 1) {
                        row.remove();
                    } else {
                        row.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
                        alert('Minimal harus ada 1 baris menu link yang tersisa, abangku.');
                    }
                }
            });
        });
    </script>
    <?php
}


// Save Footer Option ====================
add_action( 'admin_init', function(){
    if( is_admin() && isset($_GET['page']) && $_GET['page'] === 'ansor_footer' && isset($_POST['ansor_footer_submit']) ){
        if ( ! isset( $_POST['ansor_footer_nonce_field'] ) || ! wp_verify_nonce( $_POST['ansor_footer_nonce_field'], 'ansor_footer_save_action' ) ) {
            wp_die( 'Akses tidak sah atau session telah kedaluwarsa, abangku!' );
        }
        $data = isset($_POST['gp_ansor']) ? wp_unslash($_POST['gp_ansor']) : [];
        $old_data = get_option('gp_ansor', []);
        $sanitized_data = [];
        $fields_text = [
            'footer_c1_title', 'footer_hours_label', 'footer_hours_val',
            'footer_c2_title', 'footer_phone', 'footer_email', 'footer_wa',
            'footer_c3_title', 'footer_c4_title', 'footer_copyright'
        ];
        foreach ( $fields_text as $field ) {
            if ( isset( $data[$field] ) ) {
                $sanitized_data[$field] = sanitize_text_field( trim( $data[$field] ) );
            }
        }
        $fields_textarea = [ 'footer_address', 'footer_social_desc' ];
        foreach ( $fields_textarea as $field ) {
            if ( isset( $data[$field] ) ) {
                $sanitized_data[$field] = sanitize_textarea_field( trim( $data[$field] ) );
            }
        }
        $fields_social = [ 'soc_fb', 'soc_ig', 'soc_yt', 'soc_tw' ];
        foreach ( $fields_social as $field ) {
            if ( isset( $data[$field] ) ) {
                $sanitized_data[$field] = esc_url_raw( trim( $data[$field] ) );
            }
        }

        if ( isset( $data['footer_nav_items'] ) && is_array( $data['footer_nav_items'] ) ) {
            $filtered_nav = [];

            foreach ( $data['footer_nav_items'] as $item ) {
                $nav_text = isset($item['text']) ? sanitize_text_field( trim($item['text']) ) : '';
                $nav_url  = isset($item['url']) ? esc_url_raw( trim($item['url']) ) : '';
                if ( ! empty( $nav_text ) ) {
                    $filtered_nav[] = [
                        'text' => $nav_text,
                        'url'  => $nav_url
                    ];
                }
            }
            $sanitized_data['footer_nav_items'] = $filtered_nav;
        } else {
            $sanitized_data['footer_nav_items'] = [];
        }
        $allowed_fields = [
            'footer_c1_title', 'footer_address', 'footer_hours_label', 'footer_hours_val',
            'footer_c2_title', 'footer_phone', 'footer_email', 'footer_wa',
            'footer_c3_title', 'footer_nav_items',
            'footer_c4_title', 'footer_social_desc', 'soc_fb', 'soc_ig', 'soc_yt', 'soc_tw',
            'footer_copyright'
        ];
        foreach ($allowed_fields as $field) {
            if (!isset($sanitized_data[$field])) {
                unset($old_data[$field]);
            }
        }
        $merged = array_merge($old_data, $sanitized_data);
        update_option('gp_ansor', $merged);
        wp_redirect(admin_url('admin.php?page=ansor_footer&saved=1'));
        exit;
    }
});