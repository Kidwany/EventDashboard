<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $user_id
 * @property int $event_id
 * @property int $zone_id
 * @property int $group_id
 * @property string $rest_start
 * @property string $rest_end
 * @property int $is_in_rest
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_at
 */

class UserRest extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'user_rest';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(UserGroup::class, 'group_id');
    }

    public function minutes()
    {
        $rest_times = UserRest::where('user_id', $this->user_id)->get();

        $minutes = 0;

        if (count($rest_times) > 0)
        {
            foreach ($rest_times as $rest_time)
            {
                if (date('d', strtotime($rest_time->rest_start)) == date('d', strtotime(Carbon::today())))
                {
                    $start_time = Carbon::parse($rest_time->rest_start);
                    $end_time = Carbon::parse($rest_time->rest_end);
                    $minutes += $start_time->diffInMinutes($end_time);
                }
            }
        }

        return $minutes;
    }
}
