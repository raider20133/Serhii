<?php
/**
 * This class handles the checks for Gravity Forms.
 *
 * @package DEBOUNCE/Checks
 */

/**
 * Class DEBOUNCE_GravityForms
 */
class DEBOUNCE_GravityForms {

	/**
	 * The validator object
	 *
	 * @var object
	 */
	protected $validator = NULL;


	/**
	 * DEBOUNCE_GravityForms constructor.
	 */
	public function __construct() {}

	/**
	 * Set up the handler.
	 */
	public function setup() {

		add_filter( 'gform_field_validation', array( $this, 'validate' ), 10, 4 );
	}

	/**
	 * Validate form data.
	 *
	 * @param result
	 *
	 * @param value 
	 *
	 * @param form 
	 *
	 * @param field 
	 *
	 * @return result 
	 */
	public function validate( $result, $value, $form, $field ) {
	
			//$field_print = print_r($results,true);
			if($field->type == 'email' && $field->isRequired == '0' && $value==''){
				$result['is_valid'] = true;
				return $result;
			}
			
        	if ($field->type == 'email' && $result['is_valid']) {
		   	$this->validator->set_email( $value );
			$this->validator->validate();
			
			$bbdf = $this->validator->get_email_status();
			if($bbdf=='0'){$messt = 'API Error: Contact the website support.';}
			if($bbdf=='1'){$messt = 'The entered value is not an email address!';}
			if($bbdf=='2'){$messt = 'The entered email is considered as a spam-trap! Please change this email address.';}
			if($bbdf=='3'){$messt = 'Disposable emails are not supported! Use a real email address.';}
			if($bbdf=='6'){$messt = 'This email address is invalid and is not allowed. Please use a real email address.';}
			if($messt==''){$messt = 'This email address is invalid and is not allowed. Please use a real email address.';}
			
			
			if ( !$this->validator->get_is_valid() ) {
			$result['is_valid'] = false;
             		$result['message']  = empty( $field->errorMessage ) ? __( $messt, 'email-validator-by-debounce' ) : $field->errorMessage;
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