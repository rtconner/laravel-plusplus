<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;
use \DB;

class CronDay extends Command {

	protected $name = 'cron:day';

	protected $description = 'Run methods that are meant to be called on daily cron';

	/**
	 * Put any code you want to run daily here
	 */
	public function fire() {
	}

}
