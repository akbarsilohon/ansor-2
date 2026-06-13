<?php

function ansor_root_page(){ ?>
    <?php $option = get_option('gp_ansor', []); ?>
    <?php if (isset($_GET['saved'])): ?>
        <div class="updated notice is-dismissible"><p><strong>Pengaturan berhasil disimpan!</strong></p></div>
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
                <a href="<?php echo admin_url('admin.php?page=ansor'); ?>" class="ansor_nav-uri active">
                    Pengaturan Umum
                </a>
                <a href="<?php echo admin_url('admin.php?page=ansor_hero'); ?>" class="ansor_nav-uri">
                    Hero
                </a>
                <a href="<?php echo admin_url('admin.php?page=ansor_vm'); ?>" class="ansor_nav-uri">
                    Visi & Misi
                </a>
                <a href="<?php echo admin_url('admin.php?page=ansor_faqs'); ?>" class="ansor_nav-uri">
                    FAQs
                </a>
                <a href="<?php echo admin_url('admin.php?page=ansor_footer'); ?>" class="ansor_nav-uri">
                    Footer
                </a>
            </div>
        </div>

        <form method="post" action="<?php echo admin_url('admin.php?page=ansor'); ?>" class="ansor_body">
            <span class="ansor_section-title">Logo Website</span>
            <div class="form-group">
                <img src="<?php echo $option['logo'] ?? an_logo; ?>" id="brand_ansor" class="brand_ansor">
                <input type="hidden" name="gp_ansor[logo]" id="input_brand_ansor" value="<?php echo $option['logo'] ?? an_logo; ?>">
                <div class="btn-group">
                    <span class="btn-action ganti" id="ganti_brand">
                        <i class="fa-solid fa-code-compare"></i>
                        Ganti Logo
                    </span>
                    <span class="btn-action hapus" id="reset_brand">
                        <i class="fa-regular fa-trash-can"></i>
                        Reset Default
                    </span>
                </div>

                <script>
                    var defaultBrand = "<?php echo esc_js( an_logo ); ?>";
                </script>
            </div>

            <br>
            <span class="ansor_section-title small">Tombol action header</span>
            <div class="form-group">
                <label>Text</label>
                <input type="text" name="gp_ansor[btn_header_text]" value="<?php echo $option['btn_header_text'] ?? 'Kontak Kami'; ?>" />
            </div>
            <div class="form-group">
                <label>Url</label>
                <input type="url" name="gp_ansor[btn_header_url]" value="<?php echo $option['btn_header_url'] ?? ''; ?>" placeholder="Url contoh https://url.com/url-tombol" />
            </div>

            <br>
            <span class="ansor_section-title small">Insert HTML</span>
            <div class="form-grid">
                <div class="form-group">
                    <label>Insert Header</label>
                    <textarea name="gp_ansor[html_header]" class="ansor_text_area for-code" placeholder="Insert custom HTML ke header"><?php echo esc_textarea( $option['html_header'] ?? '' ); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Insert Footer</label>
                    <textarea name="gp_ansor[html_footer]" class="ansor_text_area for-code" placeholder="Insert custom HTML ke Footer"><?php echo esc_textarea( $option['html_footer'] ?? '' ); ?></textarea>
                </div>
            </div>

            <br>
            <div class="ansor_action">
                <input type="hidden" name="ansor_general" value="1" />
                <button type="submit" class="ansor_button">Simpan</button>
            </div>
        </form>
    </div>
<?php
}


// Action save general settings ====================
add_action('admin_init', function(){
    if(is_admin() && isset($_GET['page']) && $_GET['page'] === 'ansor' && isset($_POST['ansor_general'])){
        $data = isset($_POST['gp_ansor']) ? wp_unslash($_POST['gp_ansor']) : [];
        $old_data = get_option('gp_ansor', []);

        $allowed_fields = [
            'logo',
            'btn_header_text',
            'btn_header_url',
            'html_header',
            'html_footer'
        ];

        foreach ($allowed_fields as $field) {
            if (!isset($data[$field])) {
                unset($old_data[$field]);
            }
        }

        $merged = array_merge($old_data, $data);
        update_option('gp_ansor', $merged);

        wp_redirect(admin_url('admin.php?page=ansor&saved=1'));
        exit;
    }
});