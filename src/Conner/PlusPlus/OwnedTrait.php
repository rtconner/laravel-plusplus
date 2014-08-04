<?php namespace Conner\PlusPlus;

trait OwnedTrait {

	public function scopeOwned($query) {
		return $query->where('user_id', user('id'));
	}
	
}