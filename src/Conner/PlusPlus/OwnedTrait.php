<?php namespace Conner\PlusPlus;

trait OwnedTrait {

	public function scopeOwned($query) {
		return $query->where('user_id', user('id'));
	}

	public static function bootOwnedTrait() {
		static::registerModelEvent('creating', function($model){
			$model->user_id = user('id');
		});
	}
	
}