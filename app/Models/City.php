<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $country_id
 * @property int $gouvernorat_id
 * @property string $created_at
 * @property string $updated_at
 * @property Country $country
 */

class City extends Model
{
    protected $connection = 'mysql';
    protected $table = 'city';
    /**
     * @var array
     */
    protected $fillable = ['country_id', 'gouvernorat_id', 'created_at', 'updated_at'];

    public function city_ar()
    {
        return $this->hasOne(\App\Models\Arabic\City::class, 'city_id');
    }

    public function city_en()
    {
        return $this->hasOne(\App\Models\English\City::class, 'city_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id','id')->withDefault();
    }
}
