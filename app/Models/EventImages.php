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

class EventImages extends Model
{
    protected $connection = 'mysql';
    protected $table = 'event_images';
    /**
     * @var array
     */

}
