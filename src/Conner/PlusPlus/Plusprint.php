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
		$this->string($column, 36)->primary();
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
		$this->string($prefix.'street', 50)->default('');
		$this->string($prefix.'street_extra', 50)->default('');
		$this->string($prefix.'city', 50)->default('');
		$this->string($prefix.'state_a2', 2)->default('');
		$this->string($prefix.'state_name', 60)->default('');
		$this->string($prefix.'zip', 11)->default('');
		if($defaultCountry) {
			$this->string($prefix.'country_a2', 2)->default($defaultCountry);
		}
	}
	
}