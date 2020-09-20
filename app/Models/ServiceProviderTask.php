<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 */

class ServiceProviderTask extends Model
{
    protected $connection = 'mysql';
    protected $table = 'service_provider_tasks';

    protected $fillable = ['user_id','task_id'];

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id','id')->withDefault();
    }
    public function member()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }

    public function organization()
    {
        return $this->belongsTo(User::class,'organization_id','id')->withDefault();
    }

    public function group()
    {
        return $this->belongsTo(User::class,'group_id','id')->withDefault();
    }

}
