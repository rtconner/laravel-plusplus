<?php namespace Conner\PlusPlus;

use Mandrill;

/**
 * Utility to help simplify sending emails w(with mandrill)
 */

abstract class MandrillEmailer {

	public static $fromEmail = 'from@from.com';
	public static $fromName = 'name';

// 	static function doSomeThing() {
// 		$vars = array(
// 			'name'=>'',
// 			'val2'=>'Two',
// 			'val3'=>'Three',
// 		);
// 		return static::mandrillSend(
// 			'mandrill_template',
// 			'An offer has been made for '.$item->name,
// 			array($item->seller->email=>$item->seller->display),
// 			$vars
// 		);
// 	}

	static function mandrill() {
		$mandrill = new Mandrill(\Config::get('mandrill.api_key'));

		curl_setopt ($mandrill->ch, CURLOPT_CAINFO, cacert_path());

		return $mandrill;
	}

	/**
	 * This meant to be a private method
	 *
	 * @param string $template
	 * @param string $subject
	 * @param array $to - array('email@email.com'=>'Person Name')
	 * @param array $vars - array('var_name'=>'Value', 'another'=>'Another Value')
	 */
	static function mandrillSend($template, $subject, $to, $vars) {
		if(\Config::get('mail.pretend'))
			return true;

		$mandrill = static::mandrill();

		$toArray = array();
		foreach($to as $email => $name) {
			$toArray []= array(
				'email'=>$email,
				'name'=>$name,
				'type'=>'to'
			);
		}

		$varsArray = array();
		foreach($vars as $key => $val) {
			$varsArray []= array(
				'name'=>$key,
				'content'=>$val,
			);
		}

		$message = array(
			'subject'=>$subject,
			'from_email' => static::$fromEmail,
			'from_name' => static::$fromName,
			'to' => $toArray,
			'merge' => true,
			'global_merge_vars' => $varsArray,
		);

		try {
			$result = $mandrill->messages->sendTemplate($template, array(), $message);
		} catch(Mandrill_Error $e) {
			\Log::debug('A mandrill error occurred: ' . get_class($e) . "\n" . $e->getMessage());
			throw $e;
		}
	}

}