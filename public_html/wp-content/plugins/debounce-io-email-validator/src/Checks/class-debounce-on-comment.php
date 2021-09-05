<?php
/**
 * Check for comment submission.
 *
 * @package DEBOUNCE/Checks
 */

/**
 * Class DEBOUNCE_On_Comment
 */
class DEBOUNCE_On_Comment {

	/**
	 * The validator object
	 *
	 * @var object
	 */
	protected $validator = NULL;


	/**
	 * DEBOUNCE_On_Comment constructor.
	 */
	public function __construct() {}

	/**
	 * Set up the handler.
	 */
	public function setup() {

		add_action( 'pre_comment_on_post', array( $this, 'hook_is_email_filter' ) );
		add_action( 'comment_post', array( $this, 'dehook_is_email_filter' ) );
	}

	/**
	 * Add the is_email Filter
	 */
	function hook_is_email_filter() {

		add_filter( 'is_email', array( $this, 'validate' ), 10, 3 );
	}

	/**
	 * Remove the is_email Filter
	 */
	function dehook_is_email_filter() {

		remove_filter( 'is_email', array( $this, 'validate' ), 10, 3 );
	}

	/**
	 * Validate the number.
	 *
	 * @param boolean $is_valid Assumend validation status.
	 * @param string  $email    Email to validate.
	 * @param string  $context   The context.
	 *
	 * @return bool
	 */
	public function validate( $is_valid, $email, $context ) {

		if ( ! $is_valid ) {
			return FALSE;
		}
		$this->validator->set_email( $email );
		return $this->validator->validate();
	}

	/**
	 * Set the validator.
	 *
	 * @param object $validator The validator.
	 *
	 * @return object
	 */
	public function set_validator( $validator ) {

		$this->validator = (object) $validator;
		return $this->get_validator();
	}

	/**
	 * Get the validator.
	 *
	 * @return object
	 */
	public function get_validator() {

		return $this->validator;
	}
}
