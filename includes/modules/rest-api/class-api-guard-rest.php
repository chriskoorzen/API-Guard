<?php
class API_Guard_REST {
	
	protected $API_Guard;

	protected $version;

    protected $loader;

    public function __construct( $API_Guard, $version, $loader ) {

        $this->API_Guard = $API_Guard;
		$this->version = $version;
        $this->loader = $loader;

        $this-> register_hooks();

    }

	private function register_hooks() {

		$this->loader->add_filter( 'rest_authentication_errors', $this, 'block_public_rest_requests' );
        
	}

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

	public static function pretty_name() { return "REST-API Security"; }

	public static function description() {

		return "Users must be logged in and authenticated to access REST API data. Disables REST API access for anonymous users.";

	}

	public static function activation() {}

	public static function deactivation() {}
	
}