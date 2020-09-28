<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $zone_id
 * @property string $file_id
 * @property string $instructions
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 */

class ZoneInstructions extends Model
{
    protected $connection = 'mysql';
    protected $table = 'event_zone_instructions';
}
