<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $is_active
 * @property string $hex
 */
class Color extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'color';

    /**
     * @var array
     */
    protected $fillable = [
        'is_active',
        'hex',
    ];
}
