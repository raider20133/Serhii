<?php
/**
 * Registers and handles the admin area.
 *
 * @package DEBOUNCE
 */

/**
 * Class DEBOUNCE_Admin
 */
class DEBOUNCE_Admin {

	/**
	 * Plugin instance.
	 *
	 * @see   get_instance()
	 * @var  object
	 */
	protected static $instance = NULL;

	/**
	 * Load the admin interface
	 *
	 * @return void
	 */
	public function load() {

		// Check, if the admin notice should be hidden.
		if (
			current_user_can( 'manage_options' ) &&
			! empty( $_GET['debounce-api-key-notice'] ) && // Input var okay.
			wp_verify_nonce( sanitize_key( wp_unslash( $_GET['debounce-api-key-notice'] ) ), 'remove-api-key-notice' ) // Input var okay.
		) {
			update_option( 'debounce-api-key-invalid', 0 );
		}

		// Check, if the admin notice should be displayed.
		if ( 1 === (int) get_option( 'debounce-api-key-invalid' ) ) {
			add_action( 'admin_notices', array( $this, 'show_notice' ) );
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Shows the admin notice.
	 *
	 * @return void
	 */
	public function show_notice() {
		$url = admin_url( 'options-general.php' );
		$url = add_query_arg(
			array(
				'page'                => 'debounce_email_validator',
				'debounce-api-key-notice' => wp_create_nonce( 'remove-api-key-notice' ),
			),
			$url
		);
		?>
		<div class="notice notice-error">
			<p>
				<?php esc_html_e( 'The API Key is invalid.', 'email-validator-by-debounce' ); ?>
				<a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Go to settings and hide message', 'email-validator-by-debounce' ); ?></a>
			</p>

		</div>
		<?php
	}

	/**
	 * Register the admin menu.
	 *
	 * @return void
	 */
	function admin_menu() {

		add_options_page( __('DeBounce.io Email Validator', 'email-validator-by-debounce' ), __('DeBounce.io Email Validator', 'email-validator-by-debounce' ), 'manage_options', 'debounce_email_validator', array( $this, 'render_page' ) );
	}

	/**
	 * Render the page.
	 *
	 * @return void
	 */
	function render_page() {

		?>
		<div class="wrap">
			<h1><?php esc_html_e('DeBounce.io Email Validator', 'email-validator-by-debounce' ); ?></h1>
			<form action='options.php' method='post'>
				<?php
				settings_fields( 'debounce_email_validator' );
				do_settings_sections( 'debounce_email_validator' );
				submit_button();
				?>
			</form>
			
			<div class="box-area" style="">
				<h2><?php esc_html_e('Validate Email Address', 'email-validator-by-debounce'); ?></h2>
				<p><?php esc_html_e('Please enter the email address you want to validate.', 'email-validator-by-debounce'); ?></p>
				<table class="form-table">
					<tbody>
					<tr>
						<th scope="row"><?php esc_html_e('Email', 'email-validator-by-debounce'); ?></th>
						<td>
							<input id="debounce-mail" value="" type="text">
						</td>
					</tr>
					</tbody>
				</table>
				<p id="debounce-message"></p>
				<p class="submit">
					<input name="submit" id="debounce-button-validate" class="button button-primary" value="<?php echo esc_attr( __('Validate', 'email-validator-by-debounce') ); ?>" type="submit">
				</p>
				<ul id="debounce-list"></ul>
			</div>

		</div>
		<?php
	}

	/**
	 * Enqueue the necessary scripts and styles
	 *
	 * @param string $hook The page hook.
	 *
	 * @return void
	 */
	function enqueue( $hook ) {

		if ( 'settings_page_debounce_email_validator' !== $hook ) {
			return;
		}

		$plugin = DEBOUNCE_Plugin::get_instance();
		$plugin_url = $plugin->get_plugin_url();

		$min = ( ! $plugin->is_debug() ) ? '.min' : '';

		wp_register_style( 'debounce_main_style', $plugin_url . 'assets/css/debounce_style' . $min . '.css' );
		wp_register_script('debounce_main_script', $plugin_url . 'assets/js/debounce_script' . $min . '.js', array( 'jquery', 'underscore' ), '1.0', TRUE );

		$js_vars = $plugin->js_localization();
		$js_vars['ul_tpl'] = '<li><span><%- status %></span><%- mail %></li>';

		wp_localize_script( 'debounce_main_script', 'debounce', $js_vars);
		wp_enqueue_script( 'debounce_main_script' );
		wp_enqueue_style( 'debounce_main_style' );
	}

	/**
	 * Register the settings
	 *
	 * @return void
	 */
	function register_settings() {

		register_setting( 'debounce_email_validator', 'debounce_settings' );

		add_settings_section(
			'debounce_pluginPage_section',
			__( 'Email Validator Options', 'email-validator-by-debounce' ),
			array( $this, 'render_section' ),
			'debounce_email_validator'
		);

		add_settings_field(
			'debounce_api_key',
			__( 'API Key', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'apikey',
				'type'    => 'text',
				'key'     => 'debounce_api_key',
				'default' => '',
			)
		);

		add_settings_field(
			'debounce_reg_check',
			__( 'Validate email on registration', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'reg_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_reg_check',
				'default' => 0,
			)
		);

		add_settings_field(
			'debounce_comments_check',
			__( 'Validate email for comments', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'comments_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_comments_check',
				'default' => 0,
			)
		);
						
		add_settings_field(
			'debounce_is_email_check',
			__( 'Hook to is_email() function', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'is_email_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_is_email_check',
				'default' => 0,
			)
		);

		add_settings_field(
			'debounce_cf7_check',
			__( 'Hook to Contact Form 7 Forms', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'cf7_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_cf7_check',
				'default' => 0,
			)
		);
		
		add_settings_field(
			'debounce_ninja_check',
			__( 'Hook to Ninja Forms', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'ninja_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_ninja_check',
				'default' => 0,
			)
		);

		add_settings_field(
			'debounce_gravity_check',
			__( 'Hook to Gravity Forms', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'gravity_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_gravity_check',
				'default' => 0,
			)
		);

/*
		add_settings_field(
			'debounce_rc308_check',
			__( 'Block role addresses like info@, admin@, postmaster@ ...', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'rc308_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_rc308_check',
				'default' => 0,
			)
		);

		add_settings_field(
			'debounce_rc305_check',
			__( 'Block disposable email addresses (DEA)', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'rc305_check',
				'type'    => 'checkbox',
				'key'     => 'debounce_rc305_check',
				'default' => 0,
			)
		);

		add_settings_field(
			'debounce_blacklist',
			__( 'Email/Domain blacklist (use comma as separator, *@domain.tld to block a domain)', 'email-validator-by-debounce' ),
			array( $this, 'render_settings_field' ),
			'debounce_email_validator',
			'debounce_pluginPage_section',
			array(
				'id'      => 'blacklist',
				'type'    => 'text',
				'key'     => 'debounce_blacklist',
				'default' => '',
			)
		);
*/
	}

	/**
	 * Renders the section area.
	 *
	 * @return void
	 */
	function render_section() {
		echo '
		<style>
		.box-area {
			background: #FFF;
			padding: 20px;
			border-radius: 4px;
		}

		.box-area ul li {
			list-style-type: disc;
			margin-left: 30px;
		}
		pre{
			background: #f3f3f3;
			padding: 10px;
			margin-top: 20px;
		}
		.box-area h2 {
			border-bottom: 1px solid #ececec;
			padding-bottom: 10px;
		}
		</style>';
		echo wp_kses_post( __('
		<div class="box-area">
		<a href="https://debounce.io" target="_blank"><img src="https://debounce.io/wp-content/uploads/2018/01/debounce-logo-2.png" style="float: right; width: 190px;"></a>
		You can use <a href="https://debounce.io" target="_blank">DeBounce API</a> to validate email addresses in real-time on your website. DeBounce API engine perform the following checks:
		<br>
		<ul>
			<li>DNS validation, including MX record lookup</li>
			<li>Disposable email address detection</li>
			<li>Misspelled domain detection to prevent Typosquatting</li>
			<li>Syntax verification (IETF/RFC standard conformance)</li>
			<li>Temporary unavailability detection</li>
			<li>Mailbox existence checking</li>
			<li>Catch-All testing</li>
			<li>Greylisting detection</li>
			<li>SMTP connection and availability checking</li>
		<ul>
		<br>
		<b>Are you going to integrate with Gravity Forms?</b><br>
		If tou are going to integrate this plugin to Gravity Forms, first make sure you have enabled the DeBounce plugin correctly, then:
		<br><ul>
			<li>Enable HTML5 from your gravity form settings (Set “Output HTML5” to Yes - <a href="https://docs.gravityforms.com/settings-page/" target="_blank">more...</a>).</li>
			<li>If your forms have a “Confirm Email” field, remove it.</li>
		</ul>
		<br>
		<b>Where to Buy Credits?</b><br>
		You can register for a <a href="https://app.debounce.io/register" target="_blank">free API key</a> (limited to 100 address checks).<br>
		If you want to verify more than 100 addresses, please have a look at our pay-as-you-go pricing model and the <a href="https://debounce.io/pricing" target="_blank">subscription plans</a> we offer.
		</div>
		', 'email-validator-by-debounce' ) );
		
		echo '<br><br>
		<div class="box-area">
		<b>Want to validate Third-Party Fields?</b><br>
		To use the email validation in 3rd party forms, add the "debounce-mail" class to those inputs of the form that you want to validate.
		<br>
		Then add the following code to the functions.php of your child theme:
		';
		echo '
<pre>
if ( function_exists( \'debounce_activate_third_party\' ) ) {
	debounce_activate_third_party();
}
</pre>
		</div>
		
		<div class="box-area box-settings">
		<h2>Setup your Plugin:</h2>
		';

	}

	/**
	 * Render a settings field
	 *
	 * @param array $args Specify the field.
	 *
	 * @return void
	 */
	public function render_settings_field( $args ) {
		$default_args = array(
			'id'      => 'apikey',
			'type'    => 'text',
			'key'     => 'debounce_api_key',
			'default' => 0,
		);
		$args = wp_parse_args( $args, $default_args );

		$plugin = DEBOUNCE_Plugin::get_instance();
		$option = $plugin->get_option( $args['key'] );
		$value = ( NULL !== $option ) ? $option : $args['default'];

		if ( 'text' === $args['type'] ) :
		?>
		<input
			id="debounce_email_<?php echo esc_attr( $args['key'] ); ?>"
			type="text"
			name="debounce_settings[<?php echo esc_attr( $args['key'] ); ?>]"
			value="<?php echo esc_attr( $value ); ?>"
		>
		<?php
		elseif ( 'checkbox' === $args['type'] ) : ?>
		<input
			id="debounce_email_<?php echo esc_attr( $args['key'] ); ?>"
			type="checkbox"
			name="debounce_settings[<?php echo esc_attr( $args['key'] ); ?>]"
			value="1"
			<?php checked( $value, 1 ); ?>
		>
		<?php
		endif;

	}

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @return  object of this class
	 */
	public static function get_instance() {

		NULL === self::$instance and self::$instance = new self;

		return self::$instance;
	}


	/**
	 * Empty and protected constructor.
	 */
	protected function __construct() {}

	/**
	 * Empty and private clone.
	 */
	private function __clone(){}

}
