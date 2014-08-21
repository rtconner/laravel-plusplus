<?php namespace Conner\PlusPlus;

trait SchemaTrait {
	
	/**
	 * Return array of schema data for this model
	 *
	 * @return array
	 */
	public static function schema() {

		$model = new static;
		$table = $model->getTable();
		
		$schema = \DB::getDoctrineSchemaManager($table);
		$columns = $schema->listTableColumns($table);
		$fields = array();
		foreach ($columns as $column) {
			$name = $column->getName();
			$type =  $column->getType()->getName();
			$length = $column->getLength();
			$default = $column->getDefault();
			$fields[] = compact('name', 'type', 'length', 'default');
		}
		return $fields;
	}
	
	/**
	 * Get the database default values of this model
	 *
	 * @return array
	 */
	public static function defaults() {
		$schema = self::schema();
		$defaults = array();
		foreach($schema as $s) {
			$defaults[$s['name']] = $s['default'];
		}
		return $defaults;
	}
	
}