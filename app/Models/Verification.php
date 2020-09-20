<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $connection = 'mysql';
    protected $table = 'verification';

    protected $fillable = ['user_id', 'code'];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
}
