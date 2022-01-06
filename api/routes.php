<?php
// Include Enum class
include_once(plugin_dir_path(__FILE__) . '/../classes/enum.php');  // MyCLabs\Enum class

/*  Include all API files in Routes  */
include_once(plugin_dir_path(__FILE__) . '/../classes/base.php');  // object base class
include_once(plugin_dir_path(__FILE__) . '/../classes/nestedserializable.php');  // Class for serializing 

// Include Publications REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/pubs.php');  // Pubs class
include_once(plugin_dir_path(__FILE__) . '/frontend/pubs_rest.php');    // Pubs REST controller


/**
 * Register our API routes.
 */

/**
 * Function to register our new routes from the controller.
 */
function register_pubs_controllers()
{
    // Publications Controller
    $controller = new PUBS\Pubs_Rest();
    $controller->register_routes();
}

add_action('rest_api_init', 'register_pubs_controllers');
