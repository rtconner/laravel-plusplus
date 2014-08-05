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
    protected static $rules =array();

    /**
     * Custom validation messages
     * @var array
     */
    protected static $messages = array();


	/**
	 * Validator object
	 */
    protected static $validator;

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
    public static function validate($input) {
    	static::boot();
    	
        Event::fire('validating', [$input]);

        $validator = static::getValidator($input);

        if($validator->fails()) {
            static::$errors = $validator->messages();

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
		return static::$errors;
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
    	if(is_null(static::$validator)) {
    		static::$validator = Validator::make($input, static::$rules, static::$messages);
    	}

    	return static::$validator;
    }

}