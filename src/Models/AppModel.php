<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AppModel extends Model
{

	/**
	 * set fillable fields
	 */
	protected $fillable = [];
	
	/**
	 * set string fields for filtering
	 * @var array
	 */
	protected $likeFilterFields = [];

    /**
     * set boolean fields for filtering
     * @var array
     */
    protected $boolFilterFields = ['status'];

    /**
     * add filtering.
     *
     * @param  $builder: query builder.
     * @param  $filters: array of filters.
     * @return query builder.
     */
    public function scopeFilter($builder, $filters = [])
    {
        if(!$filters) {
            return $builder;
        }
        $tableName = $this->getTable();
        $defaultFillableFields = $this->fillable;
        foreach ($filters as $field => $value) {
            if(in_array($field, $this->boolFilterFields) && $value != null) {
                $builder->where($field, (bool)$value);
                continue;
            }

            if(!in_array($field, $defaultFillableFields) || !$value) {
                continue;
            }

            if(in_array($field, $this->likeFilterFields)) {
                $builder->where($tableName.'.'.$field, 'LIKE', "%$value%");
            } else if(is_array($value)) {

                $builder->whereIn($field, $value);
            } else {
                $builder->where($field, $value);
            }
        }

        return $builder;
    }

    protected static function booted()
    {
        static::addGlobalScope('PorCliente', function (Builder $builder) {
            $builder->where('cliente_id', Auth::guard()->user()->cliente_id);
            return $builder;
        });
    }
 
}