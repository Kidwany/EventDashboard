<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Estate[] $estates
 */
class Video extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'video';

    /**
     * @var array
     */
    protected $fillable = ['name', 'path', 'url', 'title', 'description', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estates()
    {
        return $this->hasMany('App\Models\Estate');
    }
}
