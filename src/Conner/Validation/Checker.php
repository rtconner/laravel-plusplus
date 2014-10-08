<?php namespace Conner\Validation;

use Validator;
use Event;

/**
 * Base class to help make validation checkers simple to create and use
 */
abstract class Checker {

	/**
	 * Errors resulting from validation
	 */
    protected static $errors;

    /**
     * Validation rules
     */
    protected static $rules = array();

    /**
     * Custom validation messages
     * @var array
     */
    protected static $messages = array();


	/**
	 * Validator objects
	 */
    protected static $validator = array();

    /**
     * Optional bootup before validation
     */
    public static function boot() {
//     	Validator::extend('custom_validation', function($attribute, $value, $parameters) {
//     	});
    }

    /**
     * Perform the validation action
     *
     * @return array
     */
    public static function validate(&$input) {
    	static::boot();
    	
        Event::fire('validating', [$input]);

        foreach((array) $input as $ipt) {
        	if(is_string($ipt)) {
        		$ipt = trim($ipt);
        	}
        }
        
        $validator = static::getValidator($input);

        if($validator->fails()) {
            return false;
        }

        return true;
    }

    /**
     * Get list of errors for this action
     *
     * @return array
     */
    public static function getErrors() {
        $validator = static::getValidator();
		return $validator->messages();
    }

    /**
     * Get list of rules
     *
     * @return array
     */
    public static function getRules() {
        return static::$rules;
    }

    /**
     * Get the last used validator Object
     *
     * @return \Validator
     */
    public static function getValidator($input=null) {
    	$class = get_called_class();
    	
    	if(empty(static::$validator[$class]) && !is_null($input)) {
    		static::$validator[$class] = static::validatorInstance($input);
    	}
    	
    	if(empty(static::$validator[$class])) {
    		return null;
//     		throw new \Exception('Must call validate() before you call getValidator(). Those are the rules. ['.$class.']');
    	}

    	return static::$validator[$class];
    }
    
    /**
     * Allow for this function to be overrident on extending classes
     */
    protected static function validatorInstance($input) {
    	return Validator::make($input, static::$rules, static::$messages);
    }

}