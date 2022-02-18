<?php

//phpinfo();
/*
 * Plugin Name: RMBL Publications Database
 * Version: 0.1
 * Plugin URI: http://www.slopesidetechnology.com/
 * Description: Publications Database Plugin
 * Author: Graham Holland
 * Author URI: http://www.slopesidetechnology.com/
 * Requires at least: 5.2
 * Tested up to: 5.4
 */

use PUBS\Utils as PUBSUtils;

const scriptver = '1.0.2142020-4';  // Use this in register script calls to bypass cache.

 /*    Include 3rd party libraries  */
// Include meekrodb database library
if (!class_exists('DB')) {
    include_once(plugin_dir_path(__FILE__) . '/lib/meekrodb.2.3.class.php');
};

/*     Include API Routes                                 */
/*     Routes file will include all API related files     */
/*     WP routes start:  /wp-json/                        */
include_once(plugin_dir_path(__FILE__) . '/api/routes.php');

// include utils class for everything
include_once(plugin_dir_path(__FILE__) . 'classes/utils.php');

// Include shortcodes
include_once(plugin_dir_path(__FILE__) . 'shortcodes.php');

// Include includes file
include_once(plugin_dir_path(__FILE__) . 'includes.php');

// Setup Database Connection Variables
$pubsdbhost = PUBSUtils::getunencryptedsetting('pubs-dbhost');
$pubsdbport = PUBSUtils::getunencryptedsetting('pubs-dbport');
$pubsdbuser = PUBSUtils::getunencryptedsetting('pubs-dbuser');
$pubsdbpassword = PUBSUtils::getencryptedsetting('pubs-dbpassword');
$pubsdbname = PUBSUtils::getunencryptedsetting('pubs-dbname');
 PUBSUtils::$db = new MeekroDB($pubsdbhost, $pubsdbuser, $pubsdbpassword, $pubsdbname, $pubsdbport);

// Include Setting Pages
include_once(plugin_dir_path(__FILE__) . '/admin/pubs.php');
include_once(plugin_dir_path(__FILE__) . '/admin/settings.php');
include_once(plugin_dir_path(__FILE__) . '/admin/pageSelections.php');

// Create Pubs Admin Pages
function pubs_register_menu_pages()
{
    add_menu_page(
        'Publications',
        'Publications',
        'manage_options',
        'rmbl-pubs/admin/pubs.php',
        'pubs_main',
        'dashicons-book',
        2
    );
    add_submenu_page(
        'rmbl-pubs/admin/pubs.php',
        'Publications Settings',
        'Settings',
        'manage_options',
        'rmbl-pubs/admin/settings.php',
        'pubs_settings'
    );
    // add_submenu_page(
    //     'rmbl-pubs/admin/pubs.php',
    //     'Publications Page Selections',
    //     'Page Selections',
    //     'manage_options',
    //     'rmbl-pubs/admin/pageSelections.php',
    //     'pubs_page_selections'
    // );
}
add_action('admin_menu', 'pubs_register_menu_pages');