<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;
use \DB;

class CodeMigrate extends Command {

	protected $name = 'code:migrate';

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

		$this->call('migrate', array('--force'=>true));
		
		$this->call('optimize');
		
		$this->call('up');
		
	}

}