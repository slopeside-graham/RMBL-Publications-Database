<?php

const scriptver = '1.0.2142020-4';  // Use this in register script calls to bypass cache.

// Register and Localize Frontend Scripts
function pubs_frontend_register_localize()
{
    // Register Kendo Scripts and styles from RMBL Catalog

    // Kendo Script
    wp_register_script('pubs-kendo-script', plugins_url('/rmbl-catalog/kendo/js/kendo.all.min.js', dirname(__FILE__)), array('jquery'), scriptver, true);
    wp_localize_script('pubs-kendo-script', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));
        
    // Kendo  styles first
    wp_register_style('pubs-kendo-common-style', plugins_url('/rmbl-catalog/kendo/styles/kendo.common.min.css', dirname(__FILE__)), array(), scriptver);
    wp_register_style('pubs-kendo-default-style', plugins_url('/rmbl-catalog/kendo/styles/kendo.default.min.css', dirname(__FILE__)), array(), scriptver);
    
    // Pubs Utilities
    wp_register_script('pubs-utils-js', plugins_url('rmbl-oubs/js/frontend/utils.js'), dirname(__FILE__), ['pubs-kendo-script'], scriptver, true);
    wp_localize_script('pubs-utils-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));
}
add_action('wp_enqueue_scripts', 'pubs_frontend_register_localize');

function pubs_admin_register_localize()
{
}
add_action('admin_enqueue_scripts', 'pubs_admin_register_localize');


// Functions to Enqueue Scripts and Styles

// Common Items
function pubs_enqueue_common()
{
    wp_enqueue_script('pubs-utils-js');
}
function pubs_enqueue_kendo()
{
    wp_enqueue_script('pubs-kendo-script');
    wp_enqueue_style('pubs-kendo-common-style');
    wp_enqueue_style('pubs-kendo-default-style');
}
function pubs_enqueue_frontend_style()
{
}

// Publications
function pubs_enqueue_frontend_get_pubs()
{
}
