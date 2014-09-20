<?php namespace Conner\PlusPlus;

use Illuminate\Support\ServiceProvider;

class PlusPlusServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function register() {
		$this->package('rtconner/laravel-plusplus', 'plusplus');
		
		include_once(__DIR__.'/../../plus-functions.php');
		include_once(__DIR__.'/../../plus-constants.php');
		include_once(__DIR__.'/../../plus-exceptions.php');
		
		$this->app['bootstrapform'] = $this->app->share(function($app) {
			$form = new BootstrapFormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

			return $form->setSessionStore($app['session.store']);
		});
	}
	
	public function boot() {
		include(__DIR__.'/../../bootstrap/plus-macros.php');
		
		$this->commands(array(
			'\Conner\Command\CodePerms',
			'\Conner\Command\CodeUpdate',
			'\Conner\Command\DBExpunge',
			'\Conner\Command\DBTruncate',
		));
		
	}
	
	public function provides() {
		return array('bootstrapform');
	}

}