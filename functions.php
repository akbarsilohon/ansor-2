<?php

define('an_name', 'GP Ansor');
define('an_ver', '1.2.3');

define('an_uri', get_template_directory_uri());
define('an_dir', get_template_directory());
function an_part( $file ){
    $path = get_template_part( $file );
    return $path;
}

// Asset Theme Image Default ========================
define('an_logo', an_uri . '/assets/img/logo.png');
define('an_fav', an_uri . '/assets/img/icon.png');
define('an_cover', an_uri . '/assets/img/cover.webp');
define('an_home_icon', an_uri . '/assets/img/home-icon.png');
define('an_admin_icon', an_uri . '/assets/img/icon-admin.min.svg');



// Function required ================================
require_once 'core/support.php';
require_once 'core/deregister.php';
require_once 'core/scripts.php';
require_once 'core/ajax.php';
require_once 'core/user.php';

// Admin Panel ======================================
require_once 'app/admin/index.php';
require_once 'app/widgets/index.php';


// Custom post CPT ==============================
require_once 'app/gallery/index.php';
require_once 'app/pengurus/index.php';
require_once 'app/program/index.php';