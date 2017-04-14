<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\ApiEloquentBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Api Model class with custom Eloquent query builder for api resources
 * @package App\Models
 */
class ApiModel extends Model
{
	/**
	 * Default pagination limit
	 * @var int
	 */
	protected $perPage = 10;

	/**
	 * Pagination limit inclusive min value
	 * @var int
	 */
	protected $perPageMin = 1;

	/**
	 * Pagination limit inclusive max value
	 * @var int
	 */
	protected $perPageMax = 20;

	/**
	 * Model validation rules for new items
	 * @var array
	 */
	protected static $storeRules = [];

	/**
	 * Model validation rules for item patch
	 * @var array
	 */
	protected static $patchRules = [];

	/**
	 * Model validation rules for item replacement
	 * @var array
	 */
	protected static $putRules = [];

	/**
	 * Model configuration
	 * @var array
	 */
	protected static $config = [];

	/**
	 * Fill the model with an array of attributes.
	 *
	 * Filter with model attributes configuration.
	 *
	 * @param  array  $attributes
	 * @return $this
	 *
	 * @throws \Illuminate\Database\Eloquent\MassAssignmentException
	 */
	public function fill(array $attributes)
	{
		// Prevent infinite loop on model boot (calling this method...)
		if (!count($attributes))
			return parent::fill($attributes);

		$user = auth()->user();

		// No user authenticated, no permissions check possible.
		if (!$user) {
			return parent::fill($attributes);
		}

		$modelsConfig = config('models');

		if (!isset($modelsConfig[static::class])) {
			return parent::fill($attributes);
		}

		$config = $modelsConfig[static::class];

		if (!isset($config['attributes'])) {
			return parent::fill($attributes);
		}

		// Alter attributes configuration and set default values if exists.

		$fillable = $this->getFillable();
		$guarded = $this->getGuarded();

		foreach ($config['attributes'] as $attribute => $attributeConfig) {
			if (isset($attributeConfig['apiCannotFillOnUserGroups'])) {
				if (in_array($user->user_group_id, $attributeConfig['apiCannotFillOnUserGroups'])) {
					if (!in_array($attribute, $guarded)) {
						$guarded[] = $attribute;
					}
					if (in_array($attribute, $fillable)) {
						unset($fillable[array_search($attribute, $fillable)]);
					}
				}
			}

			if (isset($attributeConfig['defaultValue'])) {
				$this->attributes[$attribute] = $attributeConfig['defaultValue'];
			}
		}

		// Re-base keys
		$fillable = array_values($fillable);
		$guarded = array_values($guarded);

		// Check first fillable array value for '*' or '' values
		if (count($fillable)) {
			if ((($fillable[0] == '*') || ($fillable[0] == '')) && (count($fillable) > 1)) {
				unset($fillable[0]);
			}
		}

		// Check first guarded array value for '*' or '' values
		if (count($guarded)) {
			if ((($guarded[0] == '*') || ($guarded[0] == '')) && (count($guarded) > 1)) {
				unset($guarded[0]);
			}
		}

		$this->fillable($fillable);
		$this->guard($guarded);

		return parent::fill($attributes);
	}

	/**
	 * {@inheritDoc}
	 */
	public function newEloquentBuilder($query)
	{
		return new ApiEloquentBuilder($query);
	}

	/**
	 * Get the min limit number of models to return per page.
	 *
	 * @return int
	 */
	public function getPerPageMin()
	{
		return $this->perPageMin;
	}

	/**
	 * Set the min limit number of models to return per page.
	 *
	 * @param  int  $perPageMin
	 * @return $this
	 */
	public function setPerPageMin($perPageMin)
	{
		$this->perPageMin = $perPageMin;

		return $this;
	}

	/**
	 * Get the max limit number of models to return per page.
	 *
	 * @return int
	 */
	public function getPerPageMax()
	{
		return $this->perPageMax;
	}

	/**
	 * Set the max limit number of models to return per page.
	 *
	 * @param  int  $perPageMax
	 * @return $this
	 */
	public function setPerPageMax($perPageMax)
	{
		$this->perPageMax = $perPageMax;

		return $this;
	}

	/**
	 * Model default validation rules
	 * @return string[]
	 */
	public function rules()
	{
		return static::getStoreRules();
	}

	/**
	 * Get model validation rules for new items
	 * @return array
	 */
	public static function getStoreRules()
	{
		return static::$storeRules;
	}

	/**
	 * Get model validation rules for item patch
	 * @return array
	 */
	public static function getPatchRules()
	{
		return static::$patchRules;
	}

	/**
	 * Get model validation rules for item replacement
	 * @return array
	 */
	public static function getPutRules()
	{
		return static::$putRules;
	}
}

