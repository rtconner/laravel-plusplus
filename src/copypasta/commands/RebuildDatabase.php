<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;

class RebuildDatabase extends Command {

	protected $name = 'db:rebuild';
	protected $description = 'Delete all database tables, re-create them, run seeds';

	public function fire() {
		if (\App::environment() === 'production') {
			$this->error('ERROR : Do not run db:rebuild in production');
			die();
		}

		# Example Code. You are meant to edit this
		
		$this->call('db:expunge');
		$this->call('migrate', array());
		$this->call('migrate', array('--package' => 'rtconner/laravel-addresses'));
		$this->call('db:seed');
	}

}
