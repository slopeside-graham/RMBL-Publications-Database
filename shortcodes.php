<?php

// Publication Shortcodes

include_once(plugin_dir_path( __FILE__ ) . './views/frontend/pubs/get.php');
add_shortcode( 'pubs_get', 'pubs_get' );