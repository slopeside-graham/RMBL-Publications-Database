<?php

namespace PUBS\Admin {


    class Tag_Rest extends \WP_REST_Controller
    {
        /**
         * The namespace.
         *
         * @var string
         */
        protected $namespace;

        /**
         * Rest base for the current object.
         *
         * @var string
         */
        protected $rest_base;

        /**
         * Pubs_Rest constructor.
         */
        public function __construct()
        {

            $this->namespace = 'rmbl-pubs/v1/admin';
            $this->rest_base = 'tag';
        }

        /**
         * Alias for GET transport method.
         *
         * @since 4.4.0
         * @var string
         */
        const READABLE = 'GET';

        /**
         * Alias for POST transport method.
         *
         * @since 4.4.0
         * @var string
         */
        const CREATABLE = 'POST';

        /**
         * Alias for POST, PUT, PATCH transport methods together.
         *
         * @since 4.4.0
         * @var string
         */
        const EDITABLE = 'PUT, PATCH';

        /**
         * Alias for DELETE transport method.
         *
         * @since 4.4.0
         * @var string
         */
        const DELETABLE = 'DELETE';

        /**
         * Alias for GET, POST, PUT, PATCH & DELETE transport methods together.
         *
         * @since 4.4.0
         * @var string
         */
        const ALLMETHODS = 'GET, POST, PUT, PATCH, DELETE';


        /**
         * Register the routes for the objects of the controller.
         */
        public function register_routes()
        {

            register_rest_route($this->namespace, '/' . $this->rest_base, array(

                array(
                    'methods'             => Tag_Rest::READABLE,
                    'callback'            => array($this, 'get_item'),
                    'permission_callback' => array($this, 'get_item_permissions_check'),
                ),
                array(
                    'methods'         => Tag_Rest::EDITABLE,
                    'callback'        => array($this, 'update_item'),
                    'permission_callback' => array($this, 'update_item_permissions_check'),
                    'args'            => $this->get_endpoint_args_for_item_schema(false),
                ),
                array(
                    'methods'         => Tag_Rest::CREATABLE,
                    'callback'        => array($this, 'create_item'),
                    'permission_callback' => array($this, 'create_item_permissions_check'),
                    'args'            => $this->get_endpoint_args_for_item_schema(true),
                ),
                array(
                    'methods'         => Tag_Rest::DELETABLE,
                    'callback'        => array($this, 'delete_item'),
                    'permission_callback' => array($this, 'delete_item_permissions_check'),
                    'args'            => $this->get_endpoint_args_for_item_schema(true),
                ),
                'schema' => null,
            ));
        }

        /**
         * Check permissions for the read.
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return bool|WP_Error
         */
        public function get_items_permissions_check($request)
        {
            return true;
        }
        /**
         * Check permissions for the read.
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return bool|WP_Error
         */

        public function get_item_permissions_check($request)
        {
            return true;
        }

        /**
         * Check permissions for the update
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return bool|WP_Error
         */
        public function update_item_permissions_check($request)
        {
            return new \WP_Error('rest_forbidden', esc_html__('You cannot update this Tag item.'), array('status' => $this->authorization_status_code()));
        }

        /**
         * Check permissions for the create
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return bool|WP_Error
         */
        public function create_item_permissions_check($request)
        {
            if (\PUBS\PUBS_Base::UserIsAdmin()) {
                return true;
            } else {
                return new \WP_Error('rest_forbidden', esc_html__('You cannot create this Tag item.'), array('status' => $this->authorization_status_code()));
            }
        }

        /**
         * Check permissions for the delete
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return bool|WP_Error
         */
        public function delete_item_permissions_check($request)
        {
            return new \WP_Error('rest_forbidden', esc_html__('You cannot delete this people item.'), array('status' => $this->authorization_status_code()));
        }

        /**
         * Get the Tag list.
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return mixed|WP_REST_Response
         */

        public function get_item($request)
        {
            if ($request['id'] == '') {
                // Call static function Get (use :: to reference static function)
                $tag = Tag::GetAll($request);
            } else {
                // Call static function Get (use :: to reference static function)
                $tag = Tag::Get($request['id']);
            }

            if (!is_wp_error($tag)) {
                $response = rest_ensure_response($tag);
                return $response;
            } else {
                $error_string = $tag->get_error_message();
                return new \WP_Error('Tag_Get_Error', 'An error occured: ' . $error_string, array('status' => 400));
            }
        }

        /**
         * Create Tag
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return mixed|WP_Error|WP_REST_Response
         */
        public function create_item($request)
        {
            try {
                $tag = Tag::populatefromRow($request);
                $success = $tag->Create($request);

                if (!is_wp_error($success)) {
                    return rest_ensure_response($success);
                } else {
                    $error_string = $success->get_error_message();
                    error_log(" Error creating Tag :" . $success->get_error_message(), 0);
                    return new \WP_Error('Tag_Create_Error', $error_string, array('status' => 500));
                }
            } catch (\Exception $e) {
                error_log(" Error creating Tag :" . $e->getMessage(), 0);
                return new \WP_Error('Tag_Create_Error', "An error occured creating the Tag.  Please try again.", array('status' => 500));
            }
        }

        /**
         * Sets up the proper HTTP status code for authorization.
         *
         * @return int
         */
        public function authorization_status_code()
        {

            $status = 401;

            if (is_user_logged_in()) {
                $status = 403;
            }

            return $status;
        }
    }
}
