<?php namespace Conner\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use \DB;

class DBTruncate extends Command {

	protected $name = 'db:truncate';
	protected $description = 'Truncate all database tables.';

	public function fire() {
		if (!$this->input->getOption('force') && \App::environment() === 'production') {
			$this->error('ERROR : use --force to expunge on a production environment');
			die();
		}
		
		$driver = DB::connection()->getDriverName();
		$schema = DB::getDoctrineSchemaManager();
		$tables = $schema->listTableNames();
		
		if($driver == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		}
		
		foreach($tables as $table){
			DB::table($table)->truncate();
		}
		
		if($driver == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		}
		
	}
	
	protected function getOptions() {
		return array(
			array('force', null, InputOption::VALUE_NONE, 'Force truncate to run on production'),
		);
	}
}
