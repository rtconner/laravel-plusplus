<?php namespace Conner\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use \DB;

class DBExpunge extends Command {

	protected $name = 'db:expunge';
	protected $description = 'Delete all database tables.';

	public function fire() {
		if (!$this->input->getOption('force') && \App::environment() === 'production') {
			$this->error('ERROR : use --force to expunge on a production environment');
			die();
		}
		
		switch(DB::connection()->getDriverName()) {
			case 'mysql':
				$database = DB::connection()->getDatabaseName();
				DB::statement('SET FOREIGN_KEY_CHECKS=0;');
				$expr = DB::raw("SELECT table_name FROM information_schema.tables WHERE table_schema = '$database';");
				foreach(DB::select($expr) as $row) {
					$tables[] = '`'.$row->table_name.'`';
				}
				if(!empty($tables)) {
					$expr = DB::raw('DROP TABLE IF EXISTS '.implode(', ', $tables));
					DB::statement($expr);
				}
				DB::statement('SET FOREIGN_KEY_CHECKS=1;');
				
				$this->info("Deleted all tables from MySQL database `$database`");
				break;
			case 'pgsql':
				$database = DB::connection()->getDatabaseName();
				
				$result = DB::raw('drop schema public cascade;');
				DB::statement($result);
		
				$result = DB::raw('create schema public;');
				DB::statement($result);
				
				$this->info("Deleted all tables from PostgreSQL database `$database`");
				break;
		}
		
	}
	
	protected function getOptions() {
		return array(
			array('force', null, InputOption::VALUE_NONE, 'Force expunge to run on production'),
		);
	}
}
