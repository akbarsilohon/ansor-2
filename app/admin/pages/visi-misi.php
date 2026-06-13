<?php

function ansor_render_vm_page(){
    $option = get_option('gp_ansor', []); ?>
    <?php if (isset($_GET['saved'])): ?>
        <div class="updated notice is-dismissible"><p><strong>Visi dan Misi berhasil disimpan!</strong></p></div>
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
                <a href="<?php echo admin_url('admin.php?page=ansor_vm'); ?>" class="ansor_nav-uri active">Visi & Misi</a>
                <a href="<?php echo admin_url('admin.php?page=ansor_faqs'); ?>" class="ansor_nav-uri">FAQs</a>
                <a href="<?php echo admin_url('admin.php?page=ansor_footer'); ?>" class="ansor_nav-uri">Footer</a>
            </div>
        </div>

        <form method="post" action="<?php echo admin_url('admin.php?page=ansor_vm'); ?>" class="ansor_body">
            
            <?php wp_nonce_field( 'ansor_vm_save_action', 'ansor_vm_nonce_field' ); ?>

            <span class="ansor_section-title">Pengaturan Visi & Misi</span>
            <div class="form-grid" style="margin-top: 20px;">
                <div class="form-col-left">
                    <div class="form-group">
                        <label>Sub-Title Misi</label>
                        <input type="text" name="gp_ansor[misi_subtitle]" value="<?php echo esc_attr($option['misi_subtitle'] ?? 'MISI KAMI'); ?>" />
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label>Judul Utama Misi</label>
                        <input type="text" name="gp_ansor[misi_title]" value="<?php echo esc_attr($option['misi_title'] ?? 'Misi Kami, Ansor Pati'); ?>" />
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label>Deskripsi/Teks Misi</label>
                        <textarea name="gp_ansor[misi_deskripsi]" class="ansor_text_area"><?php echo esc_textarea($option['misi_deskripsi'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="form-col-right">
                    <div class="form-group">
                        <label>Sub-Title Visi</label>
                        <input type="text" name="gp_ansor[visi_subtitle]" value="<?php echo esc_attr($option['visi_subtitle'] ?? 'VISI KAMI'); ?>" />
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Poin-Poin Visi (List Checked)</label>
                        <div id="visi-dynamic-container" style="display: flex; flex-direction: column; gap: 10px;">
                            <?php 
                            $visi_list = $option['visi_items'] ?? ['']; 
                            foreach ( $visi_list as $index => $item_value ) : 
                            ?>
                                <div class="visi-item-row" style="display: flex; gap: 10px; align-items: center;">
                                    <input type="text" name="gp_ansor[visi_items][]" value="<?php echo esc_attr($item_value); ?>" placeholder="Masukkan poin visi..." style="flex: 1;" />
                                    <button type="button" class="btn-action hapus remove-visi-row" style="padding: 10px 15px; cursor: pointer;">Hapus</button>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="button" id="add-visi-row" class="btn-action ganti" style="margin-top: 12px; padding: 10px 20px; cursor: pointer; width: max-content;">
                            + Tambah Poin Visi
                        </button>
                    </div>
                </div>
            </div>

            <br>
            <div class="ansor_action">
                <input type="hidden" name="ansor_visi_misi" value="1" />
                <button type="submit" class="ansor_button">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('visi-dynamic-container');
            const addButton = document.getElementById('add-visi-row');
            addButton.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'visi-item-row';
                newRow.style.display = 'flex';
                newRow.style.gap = '10px';
                newRow.style.alignItems = 'center';
                newRow.innerHTML = `
                    <input type="text" name="gp_ansor[visi_items][]" value="" placeholder="Masukkan poin visi..." style="flex: 1;" />
                    <button type="button" class="btn-action hapus remove-visi-row" style="padding: 10px 15px; cursor: pointer;">Hapus</button>
                `;
                container.appendChild(newRow);
            });
            container.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-visi-row')) {
                    const row = e.target.closest('.visi-item-row');
                    const allRows = container.querySelectorAll('.visi-item-row');
                    
                    if (allRows.length > 1) {
                        row.remove();
                    } else {
                        row.querySelector('input[type="text"]').value = '';
                        alert('Minimal harus ada 1 poin Visi yang tersisa.');
                    }
                }
            });
        });
    </script>
    <?php
}


// Save visi dan misi option ====================
add_action( 'admin_init', function(){
    if(is_admin() && isset($_GET['page']) && $_GET['page'] === 'ansor_vm' && isset($_POST['ansor_visi_misi'])){
        
        // REKOMENDASI: Validasi Nonce Token demi keamanan
        if ( ! isset( $_POST['ansor_vm_nonce_field'] ) || ! wp_verify_nonce( $_POST['ansor_vm_nonce_field'], 'ansor_vm_save_action' ) ) {
            wp_die( 'Akses tidak sah atau token kedaluwarsa!' );
        }

        $data = isset($_POST['gp_ansor']) ? wp_unslash($_POST['gp_ansor']) : [];
        $old_data = get_option('gp_ansor', []);

        // REKOMENDASI: Sanitasi & Filter array visi_items agar string kosong tidak ikut tersimpan
        if ( isset( $data['visi_items'] ) && is_array( $data['visi_items'] ) ) {
            // Bersihkan tag HTML berbahaya tiap poin dan buang baris kosong
            $sanitized_visi = array_map( 'sanitize_text_field', $data['visi_items'] );
            $data['visi_items'] = array_values( array_filter( $sanitized_visi ) );
        }

        $allowed_fields = [
            'misi_subtitle',
            'misi_title',
            'misi_deskripsi',
            'visi_subtitle',
            'visi_items'
        ];

        foreach ($allowed_fields as $field) {
            if (!isset($data[$field])) {
                unset($old_data[$field]);
            }
        }

        $merged = array_merge($old_data, $data);
        update_option('gp_ansor', $merged);

        wp_redirect(admin_url('admin.php?page=ansor_vm&saved=1'));
        exit;
    }
});