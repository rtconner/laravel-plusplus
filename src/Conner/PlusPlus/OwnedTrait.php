<?php namespace Conner\PlusPlus;

trait OwnedTrait {

	/**
	 * Save user_id when new records are created
	 */
	public static function bootOwnedTrait() {
		static::registerModelEvent('creating', function($model){
			if(empty($model->user_id)) {
				$model->user_id = user('id');
			}
		});
	}

	/**
	 * Build query to only find records owned by currently logged in user
	 */
	public function scopeOwned($query) {
		return $query->where('user_id', user('id'));
	}
	
	/**
	 * Build query to only find records owned by currently logged in user
	 */
	public function scopeNotOwned($query) {
		return $query->where('user_id', '<>', user('id'));
	}
	
	/**
	 * Is the currently logged in user the owner
	 */
	public function getAmOwnerAttribute() {
		$userId = user('id');
		if(empty($userId)) { return false; }
		
		return $userId == $this->attributes['user_id'];
	}
	
}