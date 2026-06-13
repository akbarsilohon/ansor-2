<?php

function ansor_render_hero_page(){
    $option = get_option('gp_ansor', []); ?>
    <?php if (isset($_GET['saved'])): ?>
        <div class="updated notice is-dismissible"><p><strong>Pengaturan Hero berhasil disimpan!</strong></p></div>
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
                <a href="<?php echo admin_url('admin.php?page=ansor'); ?>" class="ansor_nav-uri">
                    Pengaturan Umum
                </a>
                <a href="<?php echo admin_url('admin.php?page=ansor_hero'); ?>" class="ansor_nav-uri active">
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

        <form method="post" action="<?php echo admin_url('admin.php?page=ansor_hero'); ?>" class="ansor_body">
            <span class="ansor_section-title">Hero Home Page</span>
            <div class="form-group">
                <img src="<?php echo $option['hero_image'] ?? an_fav; ?>" id="ansor_hero_home" class="ansor_hero_home">
                <input type="hidden" name="gp_ansor[hero_image]" value="<?php echo $option['hero_image'] ?? an_fav; ?>" id="input_ansor_hero_home" />

                <div class="btn-group">
                    <span class="btn-action ganti" id="ganti_hero">
                        <i class="fa-solid fa-code-compare"></i>
                        Ganti Gambar
                    </span>
                    <span class="btn-action hapus" id="reset_hero">
                        <i class="fa-regular fa-trash-can"></i>
                        Reset Default
                    </span>
                </div>

                <script>
                    var defaultHeroImage = "<?php echo esc_js( an_fav ); ?>";
                </script>
            </div>

            <br>
            <span class="ansor_section-title small">Text Hero</span>
            <div class="form-group">
                <label>Badge</label>
                <?php $default_domain = wp_parse_url( home_url(), PHP_URL_HOST ); ?>
                <input type="text" name="gp_ansor[text_badge]" value="<?php echo $option['text_badge'] ?? $default_domain; ?>" />
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Heading</label>
                    <textarea name="gp_ansor[hero_heading]" class="ansor_text_area for-code" placeholder="Support HTML Tag"><?php echo esc_textarea( $option['hero_heading'] ?? 'Bergerak, Berkaya, <span>Berdampak</span>' ); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="gp_ansor[hero_desc]" class="ansor_text_area for-code" placeholder="Not Support HTML tag"><?php echo esc_textarea( $option['hero_desc'] ?? 'Pimpinan cabang gerakan pemuda Ansor Kabupaten Pati. Ansor Pati hadir sebagai ruang belajar dan berkarya bagi siapa pun yang ingin meningkatkan kapasitas diri.' ); ?></textarea>
                </div>
            </div>

            <br>
            <span class="ansor_section-title small">Action</span>
            <div class="form-group">
                <label>Text Button</label>
                <input type="text" name="gp_ansor[her_text_action]" value="<?php echo $option['her_text_action'] ?? 'Mari Diskusi'; ?>" />
            </div>

            <div class="form-group">
                <label>Url Button</label>
                <input type="text" name="gp_ansor[hero_url_action]" value="<?php echo $option['hero_url_action'] ?? ''; ?>" placeholder="Url contoh https://url.com/url-tombol" />
            </div>

            <br>
            <div class="ansor_action">
                <input type="hidden" name="ansor_hero" value="1" />
                <button type="submit" class="ansor_button">Simpan</button>
            </div>
        </form>
    </div>
    <?php
}


// Save Settings hero ====================
add_action('admin_init', function(){
    if(is_admin() && isset($_GET['page']) && $_GET['page'] === 'ansor_hero' && isset($_POST['ansor_hero'])){
        $data = isset($_POST['gp_ansor']) ? wp_unslash($_POST['gp_ansor']) : [];
        $old_data = get_option('gp_ansor', []);

        $allowed_fields = [
            'hero_image',
            'text_badge',
            'hero_heading',
            'hero_desc',
            'her_text_action',
            'hero_url_action'
        ];

        foreach ($allowed_fields as $field) {
            if (!isset($data[$field])) {
                unset($old_data[$field]);
            }
        }

        $merged = array_merge($old_data, $data);
        update_option('gp_ansor', $merged);

        wp_redirect(admin_url('admin.php?page=ansor_hero&saved=1'));
        exit;
    }
});