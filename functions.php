<?php

define('an_name', 'GP Ansor');
define('an_ver', '1.1.1');

define('an_uri', get_template_directory_uri());
define('an_dir', get_template_directory());
function an_part( $file ){
    $path = get_template_part( $file );
    return $path;
}