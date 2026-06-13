<?php

function ansor_render_faqs_page(){
    $option = get_option('gp_ansor', []); ?>
    <?php if (isset($_GET['saved'])): ?>
        <div class="updated notice is-dismissible"><p><strong>FAQs berhasil disimpan!</strong></p></div>
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
                <a href="<?php echo admin_url('admin.php?page=ansor_faqs'); ?>" class="ansor_nav-uri active">FAQs</a>
                <a href="<?php echo admin_url('admin.php?page=ansor_footer'); ?>" class="ansor_nav-uri">Footer</a>
            </div>
        </div>

        <form method="post" action="<?php echo admin_url('admin.php?page=ansor_faqs'); ?>" class="ansor_body">
            <?php wp_nonce_field( 'ansor_faqs_save_action', 'ansor_faqs_nonce_field' ); ?>
            <span class="ansor_section-title">Pengaturan FAQs (Pertanyaan Umum)</span>
            <div class="form-group" style="margin-top: 20px;">
                <label style="margin-bottom: 10px; display: block;">Daftar Pertanyaan & Jawaban</label>
                <div id="faqs-dynamic-container" style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <?php 
                    $faqs_list = $option['faqs_items'] ?? [ ['q' => '', 'a' => ''] ]; 
                    foreach ( $faqs_list as $index => $faq ) : 
                        $question = $faq['q'] ?? '';
                        $answer   = $faq['a'] ?? '';
                    ?>
                        <div class="faq-item-row" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; position: relative;">
                            
                            <div style="display: flex; flex-direction: column; gap: 12px; margin-right: 90px;">
                                <div class="form-group">
                                    <label style="font-size: 12px; color: #64748b;">Pertanyaan:</label>
                                    <input type="text" name="gp_ansor[faqs_items][<?php echo $index; ?>][q]" value="<?php echo esc_attr($question); ?>" placeholder="Contoh: Bagaimana cara mendaftar menjadi anggota GP Ansor Pati?" style="width: 100%;" />
                                </div>
                                
                                <div class="form-group">
                                    <label style="font-size: 12px; color: #64748b;">Jawaban:</label>
                                    <textarea name="gp_ansor[faqs_items][<?php echo $index; ?>][a]" class="ansor_text_area" placeholder="Tuliskan jawaban lengkap di sini..." style="min-height: 80px;"><?php echo esc_textarea($answer); ?></textarea>
                                </div>
                            </div>

                            <button type="button" class="btn-action hapus remove-faq-row" style="position: absolute; top: 15px; right: 15px; padding: 8px 15px; cursor: pointer;">Hapus</button>
                        </div>
                    <?php endforeach; ?>

                </div>

                <button type="button" id="add-faq-row" class="btn-action ganti" style="margin-top: 20px; padding: 10px 20px; cursor: pointer; width: max-content;">
                    + Tambah Pertanyaan Baru
                </button>
            </div>

            <br><br>
            <div class="ansor_action">
                <input type="hidden" name="ansor_faqs_submit" value="1" />
                <button type="submit" class="ansor_button">Simpan FAQs</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('faqs-dynamic-container');
            const addButton = document.getElementById('add-faq-row');
            addButton.addEventListener('click', function() {
                const uniqueIndex = Date.now();
                const newRow = document.createElement('div');
                newRow.className = 'faq-item-row';
                newRow.style.background = '#f8fafc';
                newRow.style.border = '1px solid #e2e8f0';
                newRow.style.padding = '15px';
                newRow.style.borderRadius = '8px';
                newRow.style.position = 'relative';
                newRow.innerHTML = `
                    <div style="display: flex; flex-direction: column; gap: 12px; margin-right: 90px;">
                        <div class="form-group">
                            <label style="font-size: 12px; color: #64748b;">Pertanyaan:</label>
                            <input type="text" name="gp_ansor[faqs_items][${uniqueIndex}][q]" value="" placeholder="Masukkan pertanyaan..." style="width: 100%;" />
                        </div>
                        <div class="form-group">
                            <label style="font-size: 12px; color: #64748b;">Jawaban:</label>
                            <textarea name="gp_ansor[faqs_items][${uniqueIndex}][a]" class="ansor_text_area" placeholder="Tuliskan jawaban lengkap di sini..." style="min-height: 80px;"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn-action hapus remove-faq-row" style="position: absolute; top: 15px; right: 15px; padding: 8px 15px; cursor: pointer;">Hapus</button>
                `;
                container.appendChild(newRow);
            });
            container.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-faq-row')) {
                    const row = e.target.closest('.faq-item-row');
                    const allRows = container.querySelectorAll('.faq-item-row');
                    if (allRows.length > 1) {
                        row.remove();
                    } else {
                        row.querySelector('input[type="text"]').value = '';
                        row.querySelector('textarea').value = '';
                        alert('Minimal harus ada 1 daftar pertanyaan FAQs yang tersisa.');
                    }
                }
            });
        });
    </script>
    <?php
}


// Save FAQs Option ====================
add_action( 'admin_init', function(){
    if( is_admin() && isset($_GET['page']) && $_GET['page'] === 'ansor_faqs' && isset($_POST['ansor_faqs_submit']) ){
        if ( ! isset( $_POST['ansor_faqs_nonce_field'] ) || ! wp_verify_nonce( $_POST['ansor_faqs_nonce_field'], 'ansor_faqs_save_action' ) ) {
            wp_die( 'Akses tidak sah atau session telah kedaluwarsa, abangku!' );
        }

        $data = isset($_POST['gp_ansor']) ? wp_unslash($_POST['gp_ansor']) : [];
        $old_data = get_option('gp_ansor', []);
        if ( isset( $data['faqs_items'] ) && is_array( $data['faqs_items'] ) ) {
            $filtered_faqs = [];

            foreach ( $data['faqs_items'] as $item ) {
                $question = isset($item['q']) ? sanitize_text_field( trim($item['q']) ) : '';
                $answer   = isset($item['a']) ? sanitize_textarea_field( trim($item['a']) ) : '';
                if ( ! empty( $question ) && ! empty( $answer ) ) {
                    $filtered_faqs[] = [
                        'q' => $question,
                        'a' => $answer
                    ];
                }
            }
            $data['faqs_items'] = $filtered_faqs;
        } else {
            $data['faqs_items'] = [];
        }

        $allowed_fields = [ 'faqs_items' ];
        foreach ($allowed_fields as $field) {
            if (!isset($data[$field])) {
                unset($old_data[$field]);
            }
        }

        $merged = array_merge($old_data, $data);
        update_option('gp_ansor', $merged);
        wp_redirect(admin_url('admin.php?page=ansor_faqs&saved=1'));
        exit;
    }
});