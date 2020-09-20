<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $connection = 'mysql';
    protected $table = 'service';

    public function city_ar()
    {
        return $this->hasOne(\App\Models\Arabic\Service::class, 'service_id');
    }

    public function city_en()
    {
        return $this->hasOne(\App\Models\English\Service::class, 'service_id');
    }
}
