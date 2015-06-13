<?php namespace Conner\PlusPlus;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;

abstract class Modelish implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity {
	
	/**
	 * User exposed observable events.
	 *
	 * @var array
	*/
	protected $observables = array();

	/**
	 * Indicates if the model exists.
	 *
	 * @var bool
	 */
	public $exists = false;
	
	/**
	 * Indicates whether attributes are snake cased on arrays.
	 *
	 * @var bool
	 */
	public static $snakeAttributes = true;
	
	/**
	 * The array of booted models.
	 *
	 * @var array
	 */
	protected static $booted = array();
	
	/**
	 * The cache of the mutated attributes for each class.
	 *
	 * @var array
	 */
	protected static $mutatorCache = array();
	
	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = array())
	{
		$this->bootIfNotBooted();
	
		$this->fill($attributes);
	}
	
	/**
	 * Check if the model needs to be booted and if so, do it.
	 *
	 * @return void
	 */
	protected function bootIfNotBooted()
	{
		$class = get_class($this);
	
		if ( ! isset(static::$booted[$class]))
		{
			static::$booted[$class] = true;
	
			$this->fireModelEvent('booting', false);
	
			static::boot();
	
			$this->fireModelEvent('booted', false);
		}
	}
	
	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
	}
	
	/**
	 * Delete the model from the database.
	 *
	 * @return bool|null
	 * @throws \Exception
	 */
	abstract public function delete();
	
	/**
	 * Update the model in the database.
	 *
	 * @param  array  $attributes
	 * @return bool|int
	 */
	abstract public function update(array $attributes = array());
	
	/**
	 * Save the model to the database.
	 *
	 * @param  array  $options
	 * @return bool
	 */
	abstract public function save(array $options = array());
	
	/**
	 * Get the value of the model's primary key.
	 *
	 * @return mixed
	 */
	abstract public function getKey();

	/**
	 * Set a given attribute on the model.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	abstract public function setAttribute($key, $value);
	
	/**
	 * Get an attribute from the model.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	abstract public function getAttribute($key);
	
	/**
	 * Get all of the current attributes on the model.
	 *
	 * @return array
	 */
	abstract public function getAttributes();
	
	/**
	 * Unset an attribute on the model.
	 *
	 * @param  string  $key
	 * @return void
	 */
	abstract public function __unset($key);
	
	/**
	 * Register an observer with the Model.
	 *
	 * @param  object|string  $class
	 * @return void
	 */
	public static function observe($class)
	{
		$instance = new static;
	
		$className = is_string($class) ? $class : get_class($class);
	
		// When registering a model observer, we will spin through the possible events
		// and determine if this observer has that method. If it does, we will hook
		// it into the model's event system, making it convenient to watch these.
		foreach ($instance->getObservableEvents() as $event)
		{
			if (method_exists($class, $event))
			{
				static::registerModelEvent($event, $className.'@'.$event);
			}
		}
	}
	
	/**
	 * Fill the model with an array of attributes.
	 *
	 * @param  array  $attributes
	 * @return $this
	 */
	public function fill(array $attributes)
	{
		foreach ($attributes as $key => $value)
		{
			$this->setAttribute($key, $value);
		}
	
		return $this;
	}
	
	/**
	 * Fill the model with an array of attributes. Force mass assignment.
	 *
	 * @param  array  $attributes
	 * @return $this
	 */
	public function forceFill(array $attributes)
	{
		// Since some versions of PHP have a bug that prevents it from properly
		// binding the late static context in a closure, we will first store
		// the model in a variable, which we will then use in the closure.
		$model = $this;
	
		return static::unguarded(function() use ($model, $attributes)
		{
			return $model->fill($attributes);
		});
	}
	
	/**
	 * Create a new instance of the given model.
	 *
	 * @param  array  $attributes
	 * @param  bool   $exists
	 * @return static
	 */
	public function newInstance($attributes = array(), $exists = false)
	{
		// This method just provides a convenient way for us to generate fresh model
		// instances of this current model. It is particularly useful during the
		// hydration of new objects via the Eloquent query builder instances.
		$model = new static((array) $attributes);
	
		$model->exists = $exists;
	
		return $model;
	}

	/**
	 * Save a new model and return the instance.
	 *
	 * @param  array  $attributes
	 * @return static
	 */
	public static function create(array $attributes)
	{
		$model = new static($attributes);
	
		$model->save();
	
		return $model;
	}
	
	/**
	 * Get the hidden attributes for the model.
	 *
	 * @return array
	 */
	public function getHidden()
	{
		return $this->hidden;
	}
	
	/**
	 * Set the hidden attributes for the model.
	 *
	 * @param  array  $hidden
	 * @return void
	 */
	public function setHidden(array $hidden)
	{
		$this->hidden = $hidden;
	}
	
	/**
	 * Add hidden attributes for the model.
	 *
	 * @param  array|string|null  $attributes
	 * @return void
	 */
	public function addHidden($attributes = null)
	{
		$attributes = is_array($attributes) ? $attributes : func_get_args();
	
		$this->hidden = array_merge($this->hidden, $attributes);
	}
	
	/**
	 * Get the visible attributes for the model.
	 *
	 * @return array
	 */
	public function getVisible()
	{
		return $this->visible;
	}
	
	/**
	 * Set the visible attributes for the model.
	 *
	 * @param  array  $visible
	 * @return void
	 */
	public function setVisible(array $visible)
	{
		$this->visible = $visible;
	}
	
	/**
	 * Add visible attributes for the model.
	 *
	 * @param  array|string|null  $attributes
	 * @return void
	 */
	public function addVisible($attributes = null)
	{
		$attributes = is_array($attributes) ? $attributes : func_get_args();
	
		$this->visible = array_merge($this->visible, $attributes);
	}
	
	/**
	 * Get the queueable identity for the entity.
	 *
	 * @return mixed
	 */
	public function getQueueableId()
	{
		return $this->getKey();
	}

	/**
	 * Remove all of the event listeners for the model.
	 *
	 * @return void
	 */
	public static function flushEventListeners()
	{
		if ( ! isset(static::$dispatcher)) return;
	
		$instance = new static;
	
		foreach ($instance->getObservableEvents() as $event)
		{
			static::$dispatcher->forget("eloquent.{$event}: ".get_called_class());
		}
	}
	
	/**
	 * Get the event dispatcher instance.
	 *
	 * @return \Illuminate\Contracts\Events\Dispatcher
	 */
	public static function getEventDispatcher()
	{
		return static::$dispatcher;
	}

	/**
	 * Set the event dispatcher instance.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $dispatcher
	 * @return void
	 */
	public static function setEventDispatcher(Dispatcher $dispatcher)
	{
		static::$dispatcher = $dispatcher;
	}

	/**
	 * Unset the event dispatcher for models.
	 *
	 * @return void
	 */
	public static function unsetEventDispatcher()
	{
		static::$dispatcher = null;
	}
	
	/**
	 * Register a model event with the dispatcher.
	 *
	 * @param  string  $event
	 * @param  \Closure|string  $callback
	 * @param  int  $priority
	 * @return void
	 */
	protected static function registerModelEvent($event, $callback, $priority = 0)
	{
		if (isset(static::$dispatcher))
		{
			$name = get_called_class();
	
			static::$dispatcher->listen("eloquent.{$event}: {$name}", $callback, $priority);
		}
	}
	
	/**
	 * Fire the given event for the model.
	 *
	 * @param  string  $event
	 * @param  bool    $halt
	 * @return mixed
	 */
	protected function fireModelEvent($event, $halt = true)
	{
		if ( ! isset(static::$dispatcher)) return true;
	
		// We will append the names of the class to the event to distinguish it from
		// other model events that are fired, allowing us to listen on each model
		// event set individually instead of catching event for all the models.
		$event = "eloquent.{$event}: ".get_class($this);
	
		$method = $halt ? 'until' : 'fire';
	
		return static::$dispatcher->$method($event, $this);
	}

	/**
	 * Get the observable event names.
	 *
	 * @return array
	 */
	public function getObservableEvents()
	{
		return array_merge(
				array(
						'creating', 'created', 'updating', 'updated',
						'deleting', 'deleted', 'saving', 'saved',
						'restoring', 'restored',
				),
				$this->observables
		);
	}

	/**
	 * Convert the model instance to JSON.
	 *
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toArray(), $options);
	}
	
	/**
	 * Convert the object into something JSON serializable.
	 *
	 * @return array
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}
	
	/**
	 * Convert the model instance to an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		$attributes = $this->attributesToArray();
	
		return array_merge($attributes, $this->relationsToArray());
	}
	
	/**
	 * Convert the model's attributes to an array.
	 *
	 * @return array
	 */
	public function attributesToArray()
	{
		$attributes = $this->getArrayableAttributes();
	
		$mutatedAttributes = $this->getMutatedAttributes();
	
		// We want to spin through all the mutated attributes for this model and call
		// the mutator for the attribute. We cache off every mutated attributes so
		// we don't have to constantly check on attributes that actually change.
		foreach ($mutatedAttributes as $key)
		{
			if ( ! array_key_exists($key, $attributes)) continue;
	
			$attributes[$key] = $this->mutateAttributeForArray(
					$key, $attributes[$key]
			);
		}
	
		// Here we will grab all of the appended, calculated attributes to this model
		// as these attributes are not really in the attributes array, but are run
		// when we need to array or JSON the model for convenience to the coder.
		foreach ($this->getArrayableAppends() as $key)
		{
			$attributes[$key] = $this->mutateAttributeForArray($key, null);
		}
	
		return $attributes;
	}
	
	/**
	 * Get an attribute array of all arrayable attributes.
	 *
	 * @return array
	 */
	protected function getArrayableAttributes()
	{
		return $this->getArrayableItems($this->attributes);
	}
	
	/**
	 * Determine if a set mutator exists for an attribute.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function hasSetMutator($key)
	{
		return method_exists($this, 'set'.studly_case($key).'Attribute');
	}
	
	/**
	 * Dynamically retrieve attributes on the model.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->getAttribute($key);
	}
	
	/**
	 * Dynamically set attributes on the model.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->setAttribute($key, $value);
	}
	
	/**
	 * Determine if the given attribute exists.
	 *
	 * @param  mixed  $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->$offset);
	}
	
	/**
	 * Get the value for a given offset.
	 *
	 * @param  mixed  $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->$offset;
	}
	
	/**
	 * Set the value for a given offset.
	 *
	 * @param  mixed  $offset
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->$offset = $value;
	}
	
	/**
	 * Unset the value for a given offset.
	 *
	 * @param  mixed  $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($this->$offset);
	}
	
	/**
	 * Determine if an attribute exists on the model.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function __isset($key)
	{
		return ($this->hasGetMutator($key) && ! is_null($this->getAttributeValue($key)));
	}
	
	/**
	 * Handle dynamic static method calls into the method.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public static function __callStatic($method, $parameters)
	{
		$instance = new static;
	
		return call_user_func_array(array($instance, $method), $parameters);
	}
	
	/**
	 * Convert the model to its string representation.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->toJson();
	}
	
	/**
	 * When a model is being unserialized, check if it needs to be booted.
	 *
	 * @return void
	 */
	public function __wakeup()
	{
		$this->bootIfNotBooted();
	}
	
}