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

class EventGates extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'event_gates';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gate_type()
    {
        return $this->belongsTo(GateType::class, 'type_id');
    }

}
