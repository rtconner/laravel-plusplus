<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;
use \DB;

class CronMonth extends Command {

	protected $name = 'cron:month';

	protected $description = 'Run methods that are meant to be called on monthly cron';

	/**
	 * Put any code you want to run monthy here
	 */
	public function fire() {
	}

}
