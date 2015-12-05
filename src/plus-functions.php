<?php

/**
 * Build array with identical keys and values
 * ex: array_make('key1', 'key2') == array('key1'=>'key1', 'key2'=>'key2')
 */
function array_make() {
	$arr = func_get_args();
	
	if(is_array($arr[0])) {
		return array_combine($arr[0], $arr[0]);
	}
	
	return array_combine($arr, $arr);
}

/**
 * Return full path to a valid cacert.pem file. Useful for CURLOPT_CAINFO option.
 */
function cacert_path()
{
	return realpath(dirname(__DIR__).DS.'cacert.pem');
}

/**
 * CSV escape
 */
function csve($str, $quote=false)
{
	if(is_array($str)) {
		$ret = array();
		foreach($str as $s) {
			$ret[] = csve($s, $quote);
		}
		return $ret;
	}
	
	if($escape === 'strip') {
		$str = str_replace ('"', '', $str);
	} elseif($escape) {
		$str = trim($str);
		$str = preg_replace ("/\"/", "\"\"", $str);
	}
	
	if($quote) {
		$str = '"'.$str.'"';
	}
	
	return $str;
}

/**
 * Get a Gravatar URL
 *
 * @param string $email The email address
 * @param string $ize in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $rating (inclusive) [ g | pg | r | x ]
 * @return string
 * @source http://gravatar.com/site/implement/images/php/
 */
function gravatar($email, $size = 80, $default = 'mm', $rating = 'g') {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$size&d=$default&r=$rating";
	return $url;
}

/**
 * Javascript escape
 */
function jse($str)
{
	$str = str_replace("\n", "", str_replace("\r", "", $str));
	return addslashes($str);
}

/**
 * Format a number to a price value (currently only USD). Always padded to two decimal places.
 *
 * @param $amount to format as a price
 * @param $fmt string
 *     USD - 0,000.00
 *     $USD - $0,000.00
 *     #USD - 0000.00
 * @return string (always returns a string type)
 */
function money($amount, $fmt = 'USD')
{
	$amount = trim($amount, '$ ');
	$amount = preg_replace("/[^0-9.]/", "", $amount);
	ceil((float)$amount * 100) / 100;
	$price = number_format((float) $amount, 2, '.', ',');

	if($fmt == '$USD') {
		$price = '$'.$price;
	} elseif($fmt == '#USD') {
		$price = preg_replace("/[^0-9.]/", "", $price);
	}

	return (string) $price;
}

/**
 * Given a number, return the number + 'th' or 'rd' etc
 */
function ordinal($cdnl)
{
	$test_c = abs($cdnl) % 10;
	$ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th'
			: (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1)
			? 'th' : 'st' : 'nd' : 'rd' : 'th'));
	return $cdnl.$ext;
}

/**
 * Fetch log of database queries
 *
 * @param string $last [false] - if true, only return last query
 * @return array of queries
 */
function queries($last = false)
{
	$queries = \DB::getQueryLog();
	
	foreach($queries as &$query) {
		$query['look'] = query_interpolate($query['query'], $query['bindings']);
	}
	
	if($last) {
		return end($queries);
	}

	return $queries;
}

/**
 * Echo log of database queries
 *
 * @param string $all
 */
function query_table()
{
	$queries = queries();

	$html = '<table style="background-color: #FFFF00;border: 1px solid #000000;color: #000000;padding-left: 10px;padding-right: 10px;width: 100%;">';
	foreach($queries as $query) {
		$html .= '<tr style="border-top: 1px dashed #000000;"><td style="padding:8px;">'.e($query['look']).'</td><td style="padding:8px;">'.e($query['time']).'</td></tr>';
	}
	
	return $html.'</table>';
}

/**
 * Replaces any parameter placeholders in a query with the value of that
 * parameter. Useful for debugging. Assumes anonymous parameters from
 * $params are are in the same order as specified in $query
 * @author glendemon
 *
 * @param string $query The sql query with parameter placeholders
 * @param array $params The array of substitution parameters
 * @return string The interpolated query
 */
function query_interpolate($query, $params)
{
	$keys = array();
	$values = $params;

	foreach ($params as $key => $value) {
		if (is_string($key)) {
			$keys[] = '/:'.$key.'/';
		} else {
			$keys[] = '/[?]/';
		}

		if (is_array($value)) {
			$values[$key] = implode(',', $value);
		}

		if (is_null($value)) {
			$values[$key] = 'NULL';
	}
	}

	// Walk the array to see if we can add single-quotes to strings
	array_walk($values, create_function('&$v, $k', 'if (!is_numeric($v) && $v!="NULL") $v = "\'".$v."\'";'));

	$query = preg_replace($keys, $values, $query, 1, $count);

	return $query;
}

/**
 * Strip new line breaks from a string
 */
function strip_nl($str)
{
	return str_replace("\n", "", str_replace("\r", "", $str));
}

/**
 * Fetch currently logged in user
 * user() // return User object of currently logged in user
 * user($field) // return single field
 *
 * Returns false if not logged in
 */
if(!function_exists('user')) {
	function user($field=null)
	{
		if(!Auth::check()) {
			return false;
		}
	
		if($field == 'id') {
			return Auth::id();
		}
		
		$user = Auth::user();
		
		if(is_null($field)) {
			return $user;
		}
		
		return $user->{$field};
	}
}

/**
 * Display an escaped value, or a dash if the value is empty
 */
function valordash($val)
{
	if(strlen($val)) { return e($val); }
	return '-';
}
