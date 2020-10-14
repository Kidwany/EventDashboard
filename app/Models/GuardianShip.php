<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $season_id
 * @property int $event_id
 * @property int $group_id
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
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'guardian_ship';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'sp_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'supervisor_id')->withDefault();
    }
}
