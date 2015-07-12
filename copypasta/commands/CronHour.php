<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;
use \DB;

class CronHour extends Command {

	protected $name = 'cron:hour';

	protected $description = 'Run methods that are meant to be called on hourly cron';

	/**
	 * Put any code you want to run hourly here
	 */
	public function fire() {
	}

}
