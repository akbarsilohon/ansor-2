<?php

function ansor_register_galeri_cpt() {
    $labels = array(
        'name'               => 'Galeri',
        'singular_name'      => 'Galeri',
        'menu_name'          => 'Galeri',
        'add_new'            => 'Tambah Baru',
        'add_new_item'       => 'Tambah Galeri',
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
        'supports'            => array('title', 'thumbnail'),
        'rewrite'             => array('slug' => 'galeri'),
        'show_in_rest'        => true,
    );

    register_post_type('galeri', $args);
}
add_action('init', 'ansor_register_galeri_cpt');


// Custom Meta Boxs ==========================
add_action( 'add_meta_boxes', 'ansor_meta_boxes_galeri_cpt');
function ansor_meta_boxes_galeri_cpt(){
    add_meta_box( 
        'gallery_detail', 
        'Koleksi Galeri Gambar', 
        'ansor_render_galeri_meta_boxes',
        'galeri',
        'normal',
        'high'
    );
}

function ansor_render_galeri_meta_boxes( $post ) {
    wp_nonce_field( 'ansor_save_galeri_meta', 'ansor_galeri_meta_nonce' );
    $images = get_post_meta( $post->ID, '_ansor_galeri_images', true );
    if ( ! is_array( $images ) ) {
        $images = array();
    }
    ?>
    <div id="ansor-galeri-container" class="ansor-meta-galeri-wrapper">
        <div id="ansor-galeri-sortable" class="ansor-galeri-grid">
            <?php foreach ( $images as $image_id ) : 
                $img_src = wp_get_attachment_image_src( $image_id, 'thumbnail' ); 
                if ( $img_src ) : ?>
                    <div class="ansor-galeri-item" data-id="<?php echo esc_attr( $image_id ); ?>">
                        <img src="<?php echo esc_url( $img_src[0] ); ?>" alt="Preview">
                        <input type="hidden" name="ansor_galeri_images[]" value="<?php echo esc_attr( $image_id ); ?>">
                        <button type="button" class="ansor-delete-galeri-btn">&times;</button>
                    </div>
                <?php endif; 
            endforeach; ?>
        </div>
        <div class="ansor-galeri-actions">
            <button type="button" id="ansor-add-galeri-btn" class="button button-primary button-large">
                <span class="dashicons dashicons-images-alt2" style="margin-top: 4px; margin-right: 4px;"></span> Tambah Gambar Galeri
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var addButton = document.getElementById('ansor-add-galeri-btn');
            var container = document.getElementById('ansor-galeri-sortable');
            var customUploader;

            if (!addButton || !container) return;

            addButton.addEventListener('click', function(e) {
                e.preventDefault();

                if (customUploader) {
                    customUploader.open();
                    return;
                }

                customUploader = wp.media({
                    title: 'Pilih Gambar untuk Galeri',
                    button: { text: 'Masukkan ke Galeri' },
                    multiple: true
                });

                customUploader.on('select', function() {
                    var selection = customUploader.state().get('selection');
                    selection.map(function(attachment) {
                        attachment = attachment.toJSON();
                        
                        var id = attachment.id;
                        var url = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                        var existingItem = container.querySelector('input[value="' + id + '"]');
                        if (!existingItem) {
                            var html = '<div class="ansor-galeri-item" data-id="' + id + '">' +
                                       '<img src="' + url + '" alt="Preview">' +
                                       '<input type="hidden" name="ansor_galeri_images[]" value="' + id + '">' +
                                       '<button type="button" class="ansor-delete-galeri-btn">&times;</button>' +
                                       '</div>';
                            container.insertAdjacentHTML('beforeend', html);
                        }
                    });
                });

                customUploader.open();
            });

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('ansor-delete-galeri-btn')) {
                    e.preventDefault();
                    var item = e.target.closest('.ansor-galeri-item');
                    if (item) {
                        item.remove();
                    }
                }
            });
        });
    </script>
    <?php
}

function ansor_save_galeri_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['ansor_galeri_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ansor_galeri_meta_nonce'], 'ansor_save_galeri_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['ansor_galeri_images'] ) && is_array( $_POST['ansor_galeri_images'] ) ) {
        $images = array_map( 'intval', $_POST['ansor_galeri_images'] );
        update_post_meta( $post_id, '_ansor_galeri_images', $images );
    } else {
        delete_post_meta( $post_id, '_ansor_galeri_images' );
    }
}
add_action( 'save_post', 'ansor_save_galeri_meta_box_data' );