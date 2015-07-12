<?php namespace Conner\PlusPlus;

abstract class Singleton {
	
	public static function getInstance()
	{
		static $instance = null;
		if (null === $instance) {
			$instance = new static();
		}
	
		return $instance;
	}
	
	protected function __construct()
	{
	}
	
	private function __clone()
	{
	}
	
	private function __wakeup()
	{
	}

	public static function __callStatic($name, $arguments)
	{
		$instance = static::getInstance();
		return call_user_func_array(array($instance, $name), $arguments);
	}
	
}