<?php namespace Conner\PlusPlus;

trait UuidableTrait {

	public static function bootUuidableTrait() {
		
		static::registerModelEvent('creating', function($model){
			$model->incrementing = false;
		
			if(!$model->exists && empty($model->{$model->getKeyName()})) {
				$model->{$model->getKeyName()} = (string) \Webpatser\Uuid\Uuid::generate(4);
			}
		});
	
	}
	
}