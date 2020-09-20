<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $created_at
 * @property string $updated_at

 */
class User_token extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_token';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'token', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
}
