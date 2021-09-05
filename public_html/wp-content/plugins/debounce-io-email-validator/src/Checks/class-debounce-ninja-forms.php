<?php
/**
 * This class handles the checks for Ninja Forms.
 *
 * @package DEBOUNCE/Checks
 */

/**
 * Class DEBOUNCE_NinjaForms
 */
class DEBOUNCE_NinjaForms {

	/**
	 * The validator object
	 *
	 * @var object
	 */
	protected $validator = NULL;


	/**
	 * DEBOUNCE_NinjaForms constructor.
	 */
	public function __construct() {}

	/**
	 * Set up the handler.
	 */
	public function setup() {

		add_filter( 'ninja_forms_submit_data', array( $this, 'validate' ), 10, 1 );
	}

	/**
	 * Validate form data.
	 *
	 * @param array  form_data
	 *
	 * @return array form_data 
	 */
	public function validate( $form_data ) {

		foreach( $form_data[ 'fields' ] as $key => $field ) {
	  	   $value = $field['value'];	
	  	   // ignore multi-line strings / textareas
		   if ( preg_match('/@.+\./', $value) && strpos($value, "\n") === false && strpos($value, '\n') === false ) {
		   	$this->validator->set_email( $value );
		    	$this->validator->validate();		    		
		    	if ( !$this->validator->get_is_valid() ) {
				   $field_id = $field['id'];
		    		$form_data['errors']['fields'][$field_id] = __( 'This email address is invalid or not allowed - please check.', 'email-validator-by-debounce' );
		    	}		    		
		   }
		}
		return $form_data;			
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
