<?php
// Include Enum class
// include_once(plugin_dir_path(__FILE__) . '/../classes/enum.php');  // MyCLabs\Enum class

/*  Include all API files in Routes  */
include_once(plugin_dir_path(__FILE__) . '/../classes/base.php');  // object base class
include_once(plugin_dir_path(__FILE__) . '/../classes/nestedserializable.php');  // Class for serializing 

// LIBRARY REST CONTROLLERS

// Include Library REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/library.php');  // Library class
include_once(plugin_dir_path(__FILE__) . '/frontend/library_rest.php');    // Library REST controller
// Include Admin Library REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/backend/library.php');  // Library class
include_once(plugin_dir_path(__FILE__) . '/backend/library_rest.php');    // Library REST controller

//AUTHOR REST CONTROLLERS

// Include Author REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/author.php');  // Library class
// include_once(plugin_dir_path(__FILE__) . '/frontend/author_rest.php');    // Library REST controller

// Include Author Admin REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/backend/author.php');  // Library class
// include_once(plugin_dir_path(__FILE__) . '/backend/author_rest.php');    // Library REST controller


//PEOPLE REST CONTROLLER

// Include People REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/people.php');  // Library class
// include_once(plugin_dir_path(__FILE__) . '/frontend/people_rest.php');    // Library REST controller
// Include People REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/backend/people.php');  // Library class
include_once(plugin_dir_path(__FILE__) . '/backend/people_rest.php');    // Library REST controller


//REFTYPE REST CONTROLLERS

// Include RefType REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/reftype.php');  // Library class
// include_once(plugin_dir_path(__FILE__) . '/frontend/reftype_rest.php');    // Library REST controller
// Include Admin RefType REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/backend/reftype.php');  // Library class
include_once(plugin_dir_path(__FILE__) . '/backend/reftype_rest.php');    // Library REST controller

//PUBLISHER REST CONTROLLERS
// Include Publisher REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/publisher.php');  // Library class
// include_once(plugin_dir_path(__FILE__) . '/frontend/reftype_rest.php');    // Library REST controller
// Include Admin Publisher REST controller and class 
include_once(plugin_dir_path(__FILE__) . '/../classes/backend/publisher.php');  // Library class
include_once(plugin_dir_path(__FILE__) . '/backend/publisher_rest.php');    // Library REST controller

//REPORT REST CONTROLLER AND CLASS
include_once(plugin_dir_path(__FILE__) . '/../classes/backend/report.php');    // Report Class
include_once(plugin_dir_path(__FILE__) . '/backend/report_rest.php');    // Report REST controller

//Tag FrontEnd REST CONTROLLER AND CLASS
include_once(plugin_dir_path(__FILE__) . '/../classes/frontend/tag.php');    // Tag Class
include_once(plugin_dir_path(__FILE__) . '/frontend/tag_rest.php');    // Tag REST controller
//Tag Admin REST CONTROLLER AND CLASS
include_once(plugin_dir_path(__FILE__) . '/../classes/backend/tag.php');    // Tag Class
include_once(plugin_dir_path(__FILE__) . '/backend/tag_rest.php');    // Tag REST controller

include_once(plugin_dir_path(__FILE__) . '/../classes/backend/library_has_tag.php');    // Tag Class

/**
 * Register our API routes.
 */

/**
 * Function to register our new routes from the controller.
 */
function register_pubs_controllers()
{
    // Library Controller
    $controller = new PUBS\Library_Rest();
    $controller->register_routes();

    // Library Admin Controller
    $controller = new PUBS\Admin\Library_Rest();
    $controller->register_routes();

    // RefType Admin Controller
    $controller = new PUBS\Admin\RefType_Rest();
    $controller->register_routes();

    // RefType Admin Controller
    $controller = new PUBS\Admin\Publisher_Rest();
    $controller->register_routes();

    // RefType Admin Controller
    $controller = new PUBS\Admin\People_Rest();
    $controller->register_routes();

    // RefType Admin Controller
    $controller = new PUBS\Admin\Report_Rest();
    $controller->register_routes();

    // Tag Controller
    $controller = new PUBS\Tag_Rest();
    $controller->register_routes();

    // Tag Admin Controller
    $controller = new PUBS\Admin\Tag_Rest();
    $controller->register_routes();
}

add_action('rest_api_init', 'register_pubs_controllers');
