<?php
// Include Enum class
// include_once(plugin_dir_path(__FILE__) . '/../classes/enum.php');  // MyCLabs\Enum class

/*  Include all API files in Routes  */
include_once(plugin_dir_path(__FILE__) . '/../classes/base.php');  // object base class
include_once(plugin_dir_path(__FILE__) . '/../classes/nestedserializable.php');  // Class for serializing 

// Include Library REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/library.php');  // Library class
include_once(plugin_dir_path(__FILE__) . '/frontend/library_rest.php');    // Library REST controller

// Include Author REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/author.php');  // Library class
// include_once(plugin_dir_path(__FILE__) . '/frontend/people_rest.php');    // Library REST controller

// Include People REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/people.php');  // Library class
// include_once(plugin_dir_path(__FILE__) . '/frontend/people_rest.php');    // Library REST controller


/**
 * Register our API routes.
 */

/**
 * Function to register our new routes from the controller.
 */
function register_pubs_controllers()
{
    // Publications Controller
    $controller = new PUBS\Library_Rest();
    $controller->register_routes();
}

add_action('rest_api_init', 'register_pubs_controllers');
