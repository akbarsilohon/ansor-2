<?php

define('an_name', 'GP Ansor');
define('an_ver', '1.1.1');

define('an_uri', get_template_directory_uri());
define('an_dir', get_template_directory());
function an_part( $file ){
    $path = get_template_part( $file );
    return $path;
}

// Asset Theme Image Default ========================
define('an_logo', an_uri . '/assets/img/logo.png');



// Function required ================================
require_once 'core/support.php';
require_once 'core/deregister.php';
require_once 'core/scripts.php';