<?php

/**
 * Checkbox with a hidden input attached that provided a fallback value of 0 
 * use $options['fallback'] to check from the default of 0
 */
Form::macro("check", function($name, $value = 1, $checked = null, $options = array()) {
	$fallback = array_key_exists('fallback', $options) ? $options['fallback'] : 0;
	unset($options['fallback']);
	
	return Form::hidden($name, $fallback) . Form::checkbox($name, $value, $checked, $options);
});

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $ize in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $rating (inclusive) [ g | pg | r | x ]
 * @param array $attributes Optional, additional key/value attributes to include in the IMG tag
 * @return Image tag HTML
 * @source http://gravatar.com/site/implement/images/php/
 */
HTML::macro("gravatar", function($email, $size = 80, $default = 'mm', $rating = 'pg', $attributes = array()) {
	return HTML::image(gravatar($email, $size, $default, $rating), null, $attributes, $secure = null);
});

HTML::macro('pageHeader', function($title, $small='') {
	
	$html = '<div class="page-header"><h1>'.e($title);
	
	if(strlen($small)) {
		$html .= '<small><i class="icon-double-angle-right"></i>'.e($small).'</small>';
	}
	
	return $html .'</h1></div>';
	
});