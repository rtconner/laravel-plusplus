<?php namespace Conner\PlusPlus;

use Illuminate\Database\Schema\Blueprint;

/**
 * Upgrades and addons over the building Laravel Blueprint class
 */

class Plusprint extends Blueprint {
	
	/**
	 * Add UUID primary field to table
	 *
	 * @return void
	 */
	public function uuid($column)
	{
		return $this->string($column, 36)->primary();
	}

	/**
	 * Add UUID primary field to table
	 *
	 * @param $prefix string to prefix all fields
	 * @param $defaultCountry two digit country code
	 * @return void
	 */
	public function address($prefix = '', $defaultCountry = 'US')
	{
		$this->string($prefix.'street', 50)->nullable();
		$this->string($prefix.'street_extra', 50)->nullable();
		$this->string($prefix.'city', 50)->nullable();
		$this->string($prefix.'state_a2', 2)->nullable();
		$this->string($prefix.'state_name', 60)->nullable();
		$this->string($prefix.'zip', 11)->nullable();
		if($defaultCountry) {
			$this->string($prefix.'country_a2', 2)->default($defaultCountry);
		}
	}
	
}