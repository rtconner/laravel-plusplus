<?php namespace Conner\PlusPlus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class ConstantModel extends Model {
	
	protected static $collection;
	
	/**
	 * Must return a Collection of all static data
	 * 
	 * @return array
	 */
	protected static function data();
	
	public static function all($columns = array('*'))
	{
		return static::buildCollection();
	}

	/**
	 * Find a model by its primary key.
	 *
	 * @param  mixed  $id
	 * @param  array  $columns
	 * @return \Illuminate\Support\Collection|static|null
	 */
	public static function find($id, $columns = array('*'))
	{
		return static::buildCollection()->find($id, $columns);
	}
	
	private function buildCollection()
	{
		if(empty(static::$collection)) {
			static::$collection = new Collection();
			
			foreach(static::data() as $row) {
				static::$collection->add(new static($row));
			}
		}
		
		return static::$collection;
	}
	
	public function setAttribute($key, $value)
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');
	}
	
	public function save(array $options = array())
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');
	}

	public function save(array $options = array())
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');
	}
	
	public function update(array $attributes = array())
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');
	}
	
	public function push()
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');
	}
	
	protected function incrementOrDecrement($column, $amount, $method)
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');
	}
	
	public function touchOwners()
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');
	}
	
	public function newQuery()
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');		
	}
	
	public function delete()
	{
		throw new ConstantDataException('Cannot write data to ConstantModel');		
	}
}