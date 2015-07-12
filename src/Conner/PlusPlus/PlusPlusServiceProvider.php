<?php namespace Conner\PlusPlus;

use Illuminate\Support\ServiceProvider;

class PlusPlusServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function register() {
		include_once(__DIR__.'/../../plus-functions.php');
		include_once(__DIR__.'/../../plus-constants.php');
		include_once(__DIR__.'/../../plus-exceptions.php');

		$this->app['bootstrapform'] = $this->app->share(function($app) {
			$form = new BootstrapFormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

			return $form->setSessionStore($app['session.store']);
		});
		
		$this->registerMacros();
	}
	
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/../../views', 'plusplus');
		
		include(__DIR__.'/../../bootstrap/plus-macros.php');

		$this->commands(array(
			'\Conner\Console\Commands\CodePerms',
			'\Conner\Console\Commands\CodeUpdate',
			'\Conner\Console\Commands\DBExpunge',
			'\Conner\Console\Commands\DBTruncate',
			'\Conner\Console\Commands\DBRebuild',
		));
	}
	
	public function registerMacros()
	{
		if($form = $this->app->make('form')) {
		
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
		
		
		if($html = $this->app->make('html')) {
		
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
	}
	
	public function provides() {
		return array('bootstrapform');
	}

}