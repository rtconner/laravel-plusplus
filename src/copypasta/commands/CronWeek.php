<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;
use \DB;

class CronWeek extends Command {

	protected $name = 'cron:week';

	protected $description = 'Run methods that are meant to be called on weekly cron';

	/**
	 * Put any code you want to run weekly here
	 */
	public function fire() {
	}

}
