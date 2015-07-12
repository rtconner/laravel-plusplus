<?php

if($form = \App::make('form')) {
	
	/**
	 * Checkbox with a hidden input attached that provided a fallback value of 0
	 * use $options['fallback'] to check from the default of 0
	 */
	$form->macro("check", function($name, $options = array()) {
		$fallback = array_key_exists('fallback', $options) ? $options['fallback'] : 0;
		unset($options['fallback']);
		
		$value = 1;
		$checked = null;
		
		return Form::hidden($name, $fallback) . Form::checkbox($name, $value, $checked, $options);
	});
}


if($html = \App::make('html')) {
	
	/**
	 * Return Twitter Bootstrap formatter page-header div
	 *
	 * @param $title string of header
	 * @small optional string of sub-heading note
	 */
	$html->macro('pageHeader', function($title, $small='', $right='') {
		
		$html = '<div class="page-header">';
	
		if(strlen($right)) {
			$html .= '<div class="pull-right">'.$right.'</div>';
		}
		
		$html .= '<h1>'.e($title);
		if(strlen($small)) {
			$html .= ' <small><i class="fa fa-angle-double-right"></i> '.e($small).'</small>';
		}
		
		return $html .'</h1></div>';
		
	});

}