<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $season_id
 * @property int $event_id
 * @property int $zone_id
 * @property int $supervisor_id
 * @property int $sp_id
 * @property string $name
 * @property string $returned_at
 * @property string $barcode
 * @property string $created_at
 * @property string $updated_at
 */

class GuardianShip extends Model
{
    protected $connection = 'mysql';
    protected $table = 'guardian_ship';
}
