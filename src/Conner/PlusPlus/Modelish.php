<?php namespace Conner\PlusPlus;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;

abstract class Modelish implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable {

	/**
	 * The model's attributes.
	 *
	 * @var array
	 */
	protected $attributes = array();
	
	/**
	 * The model attribute's original state.
	 *
	 * @var array
	*/
	protected $original = array();
	

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = array();
	
	/**
	 * The attributes that should be visible in arrays.
	 *
	 * @var array
	*/
	protected $visible = array();
	
	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	*/
	protected $appends = array();
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	*/
	protected $fillable = array();
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	*/
	protected $guarded = array('*');
	
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	*/
	protected $dates = array();
	
	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	*/
	protected $casts = array();
	
	/**
	 * The relationships that should be touched on save.
	 *
	 * @var array
	*/
	protected $touches = array();
	
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
	 * The array of global scopes on the model.
	 *
	 * @var array
	 */
	protected static $globalScopes = array();
	
	/**
	 * Indicates if all mass assignment is enabled.
	 *
	 * @var bool
	*/
	protected static $unguarded = false;
	
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
	
		$this->syncOriginal();
	
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
	 * Get an attribute from the model.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function getAttribute($key)
	{
		$value = $this->getAttributeFromArray($key);
		
		// If the attribute has a get mutator, we will call that then return what
		// it returns as the value, which is useful for transforming values on
		// retrieval from the model to a form that is more useful for usage.
		if ($this->hasGetMutator($key))
		{
			return $this->mutateAttribute($key, $value);
		}
		
		// If the attribute exists within the cast array, we will convert it to
		// an appropriate native PHP type dependant upon the associated value
		// given with the key in the pair. Dayle made this comment line up.
		if ($this->hasCast($key))
		{
			$value = $this->castAttribute($key, $value);
		}
		
		// If the attribute is listed as a date, we will convert it to a DateTime
		// instance on retrieval, which makes it quite convenient to work with
		// date fields without having to create a mutator for each property.
		elseif (in_array($key, $this->getDates()))
		{
			if ( ! is_null($value)) return $this->asDateTime($value);
		}
		
		return $value;
	}
	
	/**
	* Get an attribute from the $attributes array.
	*
	* @param  string  $key
	* @return mixed
	*/
	protected function getAttributeFromArray($key)
	{
		if (array_key_exists($key, $this->attributes))
		{
			return $this->attributes[$key];
		}
	}
	
	/**
	 * Get the value of the model's primary key.
	 *
	 * @return mixed
	 */
	public function getKey()
	{
		return $this->getAttribute($this->getKeyName());
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
	
}