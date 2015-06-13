<?php namespace Conner\PlusPlus;

use \Schema;

trait Columns {
	
	public static function columns()
	{
		$columns = Schema::getColumnListing((new static)->getTable());

		return $columns;
	}
	
}