<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $code
 * @property string $event_id
 * @property int $name
 * @property string $description
 * @property int $is_active
 * @property string $created_at
 * @property string $updated_at
 */

class Zone extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'event_zones';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany(File::class,'event_zone_instructions','zone_id','file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function supervisors()
    {
        return $this->belongsToMany(User::class,'event_zone_supervisors','zone_id','supervisor_id');
    }
}
