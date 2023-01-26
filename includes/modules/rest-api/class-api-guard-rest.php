<?php
class API_Guard_REST {

    /**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $API_Guard    The string used to uniquely identify this plugin.
	 */
	protected $API_Guard;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    public function __construct( $API_Guard, $version ) {

        $this->API_Guard = $API_Guard;
		$this->version = $version;

    }

    /**
     * Blocks all requests of the JSON REST API, unless the caller is logged in, then do nothing
     * 
     * @since    1.0.0
     * @param    array      $result         REST authentication object
     */
    public function block_public_rest_requests( $result ) {

        // Return an error if user is not logged in.
        if ( ! is_user_logged_in() ) {
            
            $code = 'rest_not_logged_in';
            $message = __( 'You are not currently logged in.' );
            $data = array( 'status' => 401 );
            
            return new WP_Error( $code, $message, $data );
        }

        return $result;
    }

}