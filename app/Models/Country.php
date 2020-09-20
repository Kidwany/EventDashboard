<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property City[] $cities
 */



class Country extends Model
{
    protected $connection = 'mysql';
    protected $table = 'country';

    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at'];
    public function country_ar()
    {
        return $this->hasOne(\App\Models\Arabic\Country::class, 'country_id')->withDefault();
    }

    public function country_en()
    {
        return $this->hasOne(\App\Models\English\Country::class, 'country_id')->withDefault();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City','country_id','id');
    }
}
