<?php namespace Conner\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;
use \DB;

class CodeUpdate extends Command {

	protected $name = 'code:update';

	protected $description = 'Update files from Git Repo. Fix permissions, clear caches, migrate';

	public function fire() {

		$this->call('down');
		
		$this->info('Pulling from Git Repo');
		$this->line(`git pull`);
		$this->line('');

		$this->info('Flushing Caches');
		$this->line(`composer dump-autoload`);
		$this->line(\Cache::flush());
		$this->call('clear-compiled');
		$this->line('');

		if($this->input->getOption('expunge')) {
			$this->call('db:expunge', array('--force'=>true));
		}
		$this->call('migrate', array('--force'=>true));
		
		$this->call('optimize');
		
		$this->call('up');
		
	}
	
	protected function getOptions() {
		return array(
			array('expunge', null, InputOption::VALUE_NONE, 'Delete and re-create database instead of migrating'),
		);
	}

}
