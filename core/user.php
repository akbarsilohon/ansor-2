<?php

add_action( 'show_user_profile', 'ansor_add_field_user_profile' );
add_action( 'edit_user_profile', 'ansor_add_field_user_profile' );
function ansor_add_field_user_profile( $user ){ ?>
    <h3 class="ansor_avatar_heading">Custom Profile</h3>
    <table class="form-table">
        <tr>
            <th><label for="ansor_avatar">Upload Foto</label></th>
            <td>
                <?php 
                $foto_id = get_user_meta($user->ID, 'ansor_avatar', true);
                if($foto_id) {
                    echo wp_get_attachment_image($foto_id, array(100, 100)) . '<br>';
                }
                ?>
                <input type="file" name="ansor_avatar" id="ansor_avatar" accept="image/*" />
                <p class="description">Pilih foto dari komputer.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ansor_instagram">Instagram Link</label></th>
            <td>
                <?php $instagram = get_user_meta($user->ID, 'ansor_instagram', true); ?>
                <input type="url" name="ansor_instagram" id="ansor_instagram" value="<?php echo esc_url($instagram); ?>" class="regular-text" placeholder="https://instagram.com/username" />
            </td>
        </tr>
        <tr>
            <th><label for="ansor_facebook">Facebook Link</label></th>
            <td>
                <?php $facebook = get_user_meta($user->ID, 'ansor_facebook', true); ?>
                <input type="url" name="ansor_facebook" id="ansor_facebook" value="<?php echo esc_url($facebook); ?>" class="regular-text" placeholder="https://facebook.com/username" />
            </td>
        </tr>
    </table>
<?php
}

add_action( 'personal_options_update', 'ansor_save_profile_picture' );
add_action( 'edit_user_profile_update', 'ansor_save_profile_picture' );
function ansor_save_profile_picture( $user_id ){
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return;
    }

    if(! empty( $_FILES['ansor_avatar']['name'] )){
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        $attachment_id = media_handle_upload( 'ansor_avatar', 0 );

        if ( ! is_wp_error( $attachment_id ) ) {
            $old_avatar = get_user_meta( $user_id, 'ansor_avatar', true );
            if ( $old_avatar ) {
                wp_delete_attachment( $old_avatar, true );
            }
            update_user_meta( $user_id, 'ansor_avatar', $attachment_id );
        }
    }

    if ( isset( $_POST['ansor_instagram'] ) ) {
        update_user_meta( $user_id, 'ansor_instagram', esc_url_raw( $_POST['ansor_instagram'] ) );
    }

    if ( isset( $_POST['ansor_facebook'] ) ) {
        update_user_meta( $user_id, 'ansor_facebook', esc_url_raw( $_POST['ansor_facebook'] ) );
    }
}

add_action('user_edit_form_tag', 'tambah_enctype_ke_form');
function tambah_enctype_ke_form() {
    echo ' enctype="multipart/form-data"';
}

add_filter( 'get_avatar', 'ansor_show_avatar_custom', 10, 5 );
function ansor_show_avatar_custom( $avatar, $id_or_email, $size, $default, $alt ){
    $user_id = 0;

    if ( is_numeric( $id_or_email ) ) {
        $user_id = (int) $id_or_email;
    } elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
        $user_id = (int) $id_or_email->user_id;
    } elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
        $user_id = $user->ID;
    }

    if ( $user_id ) {
        $foto_id = get_user_meta( $user_id, 'ansor_avatar', true );
        if ( $foto_id ) {
            $img_url = wp_get_attachment_image_url( $foto_id, $size );
            if ( $img_url ) {
                return "<img alt='{$alt}' src='{$img_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' style='object-fit: cover;' />";
            }
        }
    }

    if ( strpos( $avatar, 'gravatar.com' ) !== false && strpos( $avatar, 'd=blank' ) === false ){
        $default_local = an_home_icon;

        if ( ! empty( $default_local ) ) {
            $avatar = preg_replace( '/([?&]d=)metatags/', "$1" . urlencode( $default_local ), $avatar );
        }

        return $avatar;
    }

    $default_img = an_home_icon;
    return "<img alt='{$alt}' src='{$default_img}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
}