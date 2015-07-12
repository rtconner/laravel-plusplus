<?php namespace Conner\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class DBRebuild extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:rebuild';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Destroy all database tables and re-create and re-seed them';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		if (!$this->input->getOption('force') && \App::environment() === 'production') {
			$this->error('ERROR : use --force to destroy and rebuild in production');
			return;
		}

		$this->call('db:expunge');
		$this->call('migrate');
		$this->call('db:seed');
	}

	protected function getOptions() {
		return array(
			array('force', null, InputOption::VALUE_NONE, 'Force destroy and rebuild to run on production'),
		);
	}

}
