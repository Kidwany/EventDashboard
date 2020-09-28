<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $city_id
 * @property int $country_id
 * @property int $manager_id
 * @property string $start
 * @property string $end
 * @property string $created_at
 * @property string $updated_at
 */

class Season extends Model
{
    protected $connection = 'mysql';
    protected $table = 'season';
}
