<?php

namespace PUBS\Admin {


    class Report_Rest extends \WP_REST_Controller
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
            $this->rest_base = 'report';
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
                    'methods'             => Report_Rest::READABLE,
                    'callback'            => array($this, 'get_item'),
                    'permission_callback' => array($this, 'get_item_permissions_check'),
                ),
                array(
                    'methods'         => Report_Rest::EDITABLE,
                    'callback'        => array($this, 'update_item'),
                    'permission_callback' => array($this, 'update_item_permissions_check'),
                    'args'            => $this->get_endpoint_args_for_item_schema(false),
                ),
                array(
                    'methods'         => Report_Rest::CREATABLE,
                    'callback'        => array($this, 'create_item'),
                    'permission_callback' => array($this, 'create_item_permissions_check'),
                    'args'            => $this->get_endpoint_args_for_item_schema(true),
                ),
                array(
                    'methods'         => Report_Rest::DELETABLE,
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
            if (\PUBS\PUBS_Base::UserIsEditor()) {
                return true;
            } else {
                return new \WP_Error('rest_forbidden', esc_html__('You cannot get these Report items.'), array('status' => $this->authorization_status_code()));
            }
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
            if (\PUBS\PUBS_Base::UserIsEditor()) {
                return true;
            } else {
                return new \WP_Error('rest_forbidden', esc_html__('You cannot get this Report item.'), array('status' => $this->authorization_status_code()));
            }
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
            return new \WP_Error('rest_forbidden', esc_html__('You cannot update this Report item.'), array('status' => $this->authorization_status_code()));
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
            return new \WP_Error('rest_forbidden', esc_html__('You cannot create this Report item.'), array('status' => $this->authorization_status_code()));
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
            return new \WP_Error('rest_forbidden', esc_html__('You cannot delete this Report item.'), array('status' => $this->authorization_status_code()));
        }

        /**
         * Get the Pub list.
         *
         * @param WP_REST_Request $request get data from request.
         *
         * @return mixed|WP_REST_Response
         */

        public function get_item($request)
        {

            $report = Report::Get($request);

            if (!is_wp_error($report)) {
                $response = rest_ensure_response($report);
                return $response;
            } else {
                $error_string = $report->get_error_message();
                return new \WP_Error('Report_Get_Error', 'An error occured: ' . $error_string, array('status' => 400));
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
