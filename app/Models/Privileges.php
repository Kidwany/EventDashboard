<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privileges extends Model
{
    protected $connection = 'mysql';
    protected $table = 'privileges';

    protected $fillable = ['created_at','updated_at'];

}
