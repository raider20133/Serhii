<?php
/**
 * The main plugin class
 *
 * @package plugins
 */

/**
 * Class DEBOUNCE_Plugin
 */
class DEBOUNCE_Plugin {

	/**
	 * Whether we run in debugging mode.
	 *
	 * @var  bool
	 */
	protected static $debug = NULL;

	/**
	 * Plugin instance.
	 *
	 * @see   get_instance()
	 * @var  object
	 */
	protected static $instance = NULL;

	/**
	 * URL to this plugin's directory.
	 *
	 * @var  string
	 */
	public $plugin_url = '';

	/**
	 * Path to this plugin's directory.
	 *
	 * @var  string
	 */
	public $plugin_path = '';

	/**
	 * The API Object.
	 *
	 * @var object
	 */
	private $api = NULL;

	/**
	 * The validator object.
	 *
	 * @var object
	 */
	private $validator = NULL;

	/**
	 * The options
	 *
	 * @var array
	 */
	private $options = array();

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @return  object of this class
	 */
	public static function get_instance() {

		if ( NULL === self::$debug ) {
			self::$debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? TRUE : FALSE;
		}

		NULL === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Used for regular plugin work.
	 *
	 * @wp-hook  plugins_loaded
	 * @return   void
	 */
	public function plugin_setup() {

		$this->plugin_url	= plugins_url( '/', dirname( __FILE__ ) );
		$this->plugin_path   = 'email-validator-by-debounce/';
		$this->load_language( 'email-validator-by-debounce' );

		// Load Options.
		$this->set_options( get_option( 'debounce_settings', array() ) );

		// Load the API.
		require_once( dirname( __FILE__ ) . '/API/class-debounce-api.php' );
		require_once( dirname( __FILE__ ) . '/API/class-debounce-email-validator.php' );
		$this->api = new DEBOUNCE_API();
		$this->api->set_apikey( $this->get_option( 'debounce_api_key' ) );
		$this->validator = new DEBOUNCE_Email_Validator();
		$this->validator->set_api( $this->api );
		if ( 0 === (int) $this->get_option( 'debounce_rc305_check' ) ) {
			$this->validator->add_status_valid('305');
		}
		if ( 0 === (int) $this->get_option( 'debounce_rc308_check' ) ) {
			$this->validator->add_status_valid('308');
		}
		$this->validator->set_blacklist( $this->get_option( 'debounce_blacklist' ) );

		// Load the Ajax Interface.
		require_once( dirname( __FILE__ ) . '/AJAX/class-debounce-ajax-handler.php' );
		require_once( dirname( __FILE__ ) . '/AJAX/class-debounce-ajax-validate-email.php' );
		$ajax_handler = new DEBOUNCE_Ajax_Handler();
		$ajax = new DEBOUNCE_Ajax_Validate_Email();
		$ajax->set_validator( $this->validator );
		$ajax->set_handler( $ajax_handler );

		if ( 1 === (int) $this->get_option( 'debounce_is_email_check' ) ) {
			require_once( dirname( __FILE__ ) . '/Checks/class-debounce-is-email.php' );
			$email_check = new DEBOUNCE_is_email();
			$email_check->set_validator( $this->validator );
			$email_check->setup();
		}

		if ( 1 === (int) $this->get_option( 'debounce_cf7_check' ) ) {
			require_once( dirname( __FILE__ ) . '/Checks/class-debounce-cf7.php' );
			$email_check = new DEBOUNCE_ContactForm7();
			$email_check->set_validator( $this->validator );
			$email_check->setup();
		}

		if ( 1 === (int) $this->get_option( 'debounce_ninja_check' ) ) {
			require_once( dirname( __FILE__ ) . '/Checks/class-debounce-ninja-forms.php' );
			$email_check = new DEBOUNCE_NinjaForms();
			$email_check->set_validator( $this->validator );
			$email_check->setup();
		}

		if ( 1 === (int) $this->get_option( 'debounce_gravity_check' ) ) {
			require_once( dirname( __FILE__ ) . '/Checks/class-debounce-gravity-forms.php' );
			$email_check = new DEBOUNCE_GravityForms();
			$email_check->set_validator( $this->validator );
			$email_check->setup();
		}

		if ( 1 === (int) $this->get_option( 'debounce_comments_check' ) ) {
			require_once( dirname( __FILE__ ) . '/Checks/class-debounce-on-comment.php' );
			$comment_check = new DEBOUNCE_On_Comment();
			$comment_check->set_validator( $this->validator );
			$comment_check->setup();
		}

		if ( 1 === (int) $this->get_option( 'debounce_reg_check' ) ) {
			require_once( dirname( __FILE__ ) . '/Checks/class-debounce-on-registration.php' );
			$comment_check = new DEBOUNCE_On_Registration();
			$comment_check->set_validator( $this->validator );
			$comment_check->setup();
		}

		/**
		 * Filters whether the ajax call is only for logged in users. Default: FALSE.
		 *
		 * @param bool
		 */
		$ajax_is_private = (bool) apply_filters( 'debounce_api_is_private', TRUE );
		$ajax->set_private( $ajax_is_private );
		$ajax->register();

		add_action( 'wp_enqueue_scripts', array( $this, 'register_script' ) );

		if ( is_admin() ) {
			// Load the Admin Interface.
			require_once( dirname( __FILE__ ) . '/class-debounce-admin.php' );
			$admin = DEBOUNCE_Admin::get_instance();
			$admin->load();
		}
	}

	/**
	 * Whether we are in debug mode.
	 *
	 * @return bool
	 */
	public function is_debug() {

		return self::$debug;
	}

	/**
	 * Register the Javascript.
	 */
	public function register_script() {

		// Minimize the script on production site.
		$min = '';
		if ( ! self::$debug ) {
			$min = '.min';
		}
		wp_register_script('debounce_frontend_script', $this->get_plugin_url() . 'assets/js/debounce_form_script' . $min . '.js', array( 'jquery', 'underscore' ), '1.0', TRUE );

		$js_vars = $this->js_localization();

		// The HTML templates.
		$js_vars['tpl']    = '<span class="debounce-error"><%- status %> <%- mail %></span>';

		wp_localize_script( 'debounce_frontend_script', 'debounce', $js_vars);
	}

	/**
	 * Enqueue Script on frontend.
	 *
	 * @see debounce_activate_third_party()
	 */
	public function enqueue_frontend() {
		wp_enqueue_script( 'debounce_frontend_script' );
	}

	/**
	 * Add footer styles on frontend
	 */
	public function footer_styles() {
		?><style>.debounce-error {color: #f00;}</style><?php
	}
	/**
	 * Get the plugin url
	 *
	 * @return string plugin url.
	 */
	public function get_plugin_url() {

		return $this->plugin_url;
	}

	/**
	 * Get the plugin url
	 *
	 * @return string plugin path.
	 */
	public function get_plugin_path() {

		return $this->plugin_path;
	}

	/**
	 * Localized Javascript Variables.
	 *
	 * @return array
	 **/
	public function js_localization() {

		return array(
			'AJAX_URL' => esc_js( admin_url( 'admin-ajax.php' ) ),
			'nonce'    => esc_js( wp_create_nonce( 'validate-email' ) ),

			'0'      => __( 'Invalid - Invalid API or Credits Low', 'email-validator-by-debounce' ),
			'1'      => __( 'Invalid - Syntax, Not an email', 'email-validator-by-debounce' ),
			'2'      => __( 'Invalid - Spamtrap, Spam-trap by ESPs', 'email-validator-by-debounce' ),
			'3'      => __( 'Invalid - Disposable, A temporary, disposable address', 'email-validator-by-debounce' ),
			'4'      => __( 'Risk - Accept-All, A domain-wide setting', 'email-validator-by-debounce' ),
			'5'      => __( 'OK - Delivarable, Verified as real address', 'email-validator-by-debounce' ),
			'6'      => __( 'Invalid - Verified as not valid.', 'email-validator-by-debounce' ),
			'7'      => __( 'Risk - Unknown, The server cannot be reached', 'email-validator-by-debounce' ),
			'8'      => __( 'Role accounts such as info, support, etc.', 'email-validator-by-debounce' ),
		);
	}

	/**
	 * Get the options.
	 *
	 * @return array
	 */
	public function get_options() {

		return $this->options;
	}

	/**
	 * Set the options.
	 *
	 * @param array $options The options.
	 *
	 * @return array
	 */
	public function set_options( $options ) {

		$defaults = array(
			'debounce_api_key' => '',
		);
		$this->options = wp_parse_args( (array) $options, $defaults );
		return $this->get_options();
	}

	/**
	 * Return a single option.
	 *
	 * @param string $option_key The option key.
	 *
	 * @return mixed|null
	 */
	public function get_option( $option_key ) {

		return ( ! empty( $this->options[ $option_key ] ) ) ? $this->options[ $option_key ] : NULL;
	}



	/**
	 * Empty and protected constructor.
	 */
	protected function __construct() {}

	/**
	 * Empty and private clone.
	 */
	private function __clone(){}


	/**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files (admin and
	 * front-end for example).
	 *
	 * @wp-hook init
	 * @param   string $domain The plugins domain.
	 * @return  void
	 */
	public function load_language( $domain ) {

		load_plugin_textdomain(
			$domain,
			FALSE,
			$this->plugin_path . 'languages'
		);
	}
}
