<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Artisan;
use \DB;

class CodePerms extends Command {

	protected $name = 'code:perms';

	protected $description = 'Fix file permissions on a unix server';

	public function fire() {

		$this->call('down');
		
		if(stristr(PHP_OS, 'LINUX')) {
			$this->info('Updating file permissions');
			$this->line(`find . -type f -exec chmod 660 {} \;`);
			$this->line(`find . -type d -exec chmod 770 {} \;`);
			$this->line(`chmod +x ./artisan`);
			$this->line('');
		}

		$this->call('up');
		
	}

}
