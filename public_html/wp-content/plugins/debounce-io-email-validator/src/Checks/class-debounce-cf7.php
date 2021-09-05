<?php
/**
 * This class handles the checks for Contact Form 7.
 *
 * @package DEBOUNCE/Checks
 */

/**
 * Class DEBOUNCE_ContactForm7
 */
class DEBOUNCE_ContactForm7 {

	/**
	 * The validator object
	 *
	 * @var object
	 */
	protected $validator = NULL;


	/**
	 * DEBOUNCE_ContactForm7 constructor.
	 */
	public function __construct() {}

	/**
	 * Set up the handler.
	 */
	public function setup() {

		 add_filter( 'wpcf7_validate_email', array( $this, 'validate' ), 20, 2 );
		 add_filter( 'wpcf7_validate_email*', array( $this, 'validate' ), 20, 2 );
	}

	/**
	 * Validate form data.
	 *
	 * @param  result
	 * @param  tag
	 *
	 * @return result
	 */
	public function validate( $result, $tag ) {

   	$tag = new WPCF7_FormTag( $tag );
     	$type = $tag->type;
      $name = $tag->name;
      if ('email' == $type || 'email*' == $type) {
      	$this->validator->set_email( sanitize_email($_POST[$name]) );
		   $this->validator->validate();	
        	if( !$this->validator->get_is_valid() ) {
             $result->invalidate( $tag, __( 'This email address is invalid or not allowed - please check.', 'email-validator-by-debounce' ) );
         }
      }
      return $result;
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
