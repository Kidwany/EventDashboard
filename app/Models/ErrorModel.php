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
class ErrorModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'error_log';

    /**
     * @var array
     */
    protected $fillable = ['page_name', 'function_name','Is_android_Web','error_message','created_at', 'updated_at'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';


}
