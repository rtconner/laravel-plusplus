<?php namespace Conner\PlusPlus;

use Crypt;

/**
 * Helper for Models that have fields that need to be encrypted
 *
 * @author Robert Conner <rtconner@smarter.bz>
 */
trait CryptFieldsTrait {
	
	private function ___cryptSet($key, $value) {
		if(strlen($value)) {
			$value = Crypt::encrypt($value);
		}
		$this->attributes[$key] = $value;
	}
	
	private function ___cryptGet($key) {
		if(array_key_exists($key, $this->attributes)) {
			if(strlen($this->attributes[$key]))
				return Crypt::decrypt($this->attributes[$key]);
		}
	}
	
}