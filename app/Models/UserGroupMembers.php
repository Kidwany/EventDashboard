<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 * @property integer $id
 * @property integer $event_id
 * @property integer $color_id
 * @property integer $zone_id
 * @property string  $name
 * @property integer $is_active
 *
 */
class UserGroupMembers extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'user_group_members';

    /**
     * @var string[]
     */
    protected $fillable = ['event_id','color_id','name','is_active'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id')->withDefault();
    }


}
