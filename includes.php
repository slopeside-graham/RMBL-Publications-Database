<?php

const scriptver = '1.0.2142020-4';  // Use this in register script calls to bypass cache.

// Register and Localize Frontend Scripts
function pubs_frontend_register_localize()
{
    // Register Kendo Scripts and styles from RMBL Catalog

    // Kendo Script
    wp_register_script('pubs-kendo-js', plugins_url('/rmbl-catalog/kendo/js/kendo.all.min.js', dirname(__FILE__)), array('jquery'), scriptver, true);
    wp_localize_script('pubs-kendo-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    // Kendo  styles first
    wp_register_style('pubs-kendo-common-style', plugins_url('/rmbl-catalog/kendo/styles/kendo.common.min.css', dirname(__FILE__)), array(), scriptver);
    wp_register_style('pubs-kendo-default-style', plugins_url('/rmbl-catalog/kendo/styles/kendo.default.min.css', dirname(__FILE__)), array(), scriptver);

    // Pubs Utilities
    wp_register_script('pubs-utils-js', plugins_url('rmbl-pubs/js/frontend/utils.js'), dirname(__FILE__), ['pubs-kendo-js'], scriptver, true);
    wp_localize_script('pubs-utils-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    // Library Frontend
    wp_register_script('library-fe-ds-js', plugins_url('rmbl-pubs/js/frontend/library/ds.js'), dirname(__FILE__), ['pubs-utils-js'], scriptver, true);
    wp_localize_script('library-fe-ds-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    wp_register_script('library-fe-get-js', plugins_url('rmbl-pubs/js/frontend/library/get.js'), dirname(__FILE__), ['library-fe-ds-js'], scriptver, true);
    wp_localize_script('library-fe-get-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    wp_register_style('library-fe-style', plugins_url('rmbl-pubs/css/frontend/library/style.css'));
}
add_action('wp_enqueue_scripts', 'pubs_frontend_register_localize');

function pubs_admin_register_localize()
{
    // Register Kendo Scripts and styles from RMBL Catalog

    // Kendo Script
    wp_register_script('pubs-kendo-js', plugins_url('/rmbl-catalog/kendo/js/kendo.all.min.js', dirname(__FILE__)), array('jquery'), scriptver, true);
    wp_localize_script('pubs-kendo-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    // Kendo  styles first
    wp_register_style('pubs-kendo-common-style', plugins_url('/rmbl-catalog/kendo/styles/kendo.common.min.css', dirname(__FILE__)), array(), scriptver);
    wp_register_style('pubs-kendo-default-style', plugins_url('/rmbl-catalog/kendo/styles/kendo.default.min.css', dirname(__FILE__)), array(), scriptver);

    // Pubs Utilities
    wp_register_script('pubs-utils-js', plugins_url('rmbl-pubs/js/frontend/utils.js'), dirname(__FILE__), ['pubs-kendo-js'], scriptver, true);
    wp_localize_script('pubs-utils-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    // Library Admin
    wp_register_script('library-be-js', plugins_url('rmbl-pubs/js/backend/pubs.js'), dirname(__FILE__), ['pubs-utils-js'], scriptver, true);
    wp_localize_script('library-be-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    wp_register_script('library-be-ds-js', plugins_url('rmbl-pubs/js/backend/library/ds.js'), dirname(__FILE__), ['pubs-utils-js'], scriptver, true);
    wp_localize_script('library-be-ds-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    wp_register_script('library-be-grid-js', plugins_url('rmbl-pubs/js/backend/library/grid.js'), dirname(__FILE__), ['library-be-ds-js'], scriptver, true);
    wp_localize_script('library-be-grid-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    wp_register_style('library-be-style', plugins_url('rmbl-pubs/css/frontend/library/style.css'));

    // RefType Admin
    wp_register_script('reftype-be-ds-js', plugins_url('rmbl-pubs/js/backend/reftype/ds.js'), dirname(__FILE__), ['pubs-utils-js'], scriptver, true);
    wp_localize_script('reftype-be-ds-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    // Publisher Admin
    wp_register_script('publisher-be-ds-js', plugins_url('rmbl-pubs/js/backend/publisher/ds.js'), dirname(__FILE__), ['pubs-utils-js'], scriptver, true);
    wp_localize_script('publisher-be-ds-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));

    // People Admin
    wp_register_script('people-be-ds-js', plugins_url('rmbl-pubs/js/backend/people/ds.js'), dirname(__FILE__), ['pubs-utils-js'], scriptver, true);
    wp_localize_script('people-be-ds-js', 'wpApiSettings', array('root' => esc_url_raw(rest_url()), 'nonce' => wp_create_nonce('wp_rest')));
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
    wp_enqueue_script('pubs-kendo-js');
    wp_enqueue_style('pubs-kendo-common-style');
    wp_enqueue_style('pubs-kendo-default-style');
}
function pubs_enqueue_frontend_style()
{
    wp_enqueue_style('library-fe-style');
}

// Publications
function pubs_enqueue_frontend_get_library()
{
    wp_enqueue_script('pubs-kendo-js');
    wp_enqueue_script('pubs-utils-js');
    wp_enqueue_script('library-fe-ds-js');
    wp_enqueue_script('library-fe-get-js');

    wp_enqueue_style('library-fe-style');
}

function pubs_enqueue_backend_library()
{
    wp_enqueue_script('pubs-kendo-js');
    wp_enqueue_script('pubs-utils-js');
    wp_enqueue_script('library-be-js');
    wp_enqueue_script('library-be-ds-js');
    wp_enqueue_script('library-be-grid-js');

    wp_enqueue_script('reftype-be-ds-js');

    wp_enqueue_script('publisher-be-ds-js');

    wp_enqueue_script('people-be-ds-js');

    wp_enqueue_style('library-be-style');
}
