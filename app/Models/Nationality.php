<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property City[] $cities
 */



class Nationality extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'nationality';

    /**
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at'];
}
