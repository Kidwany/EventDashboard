<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $event_id
 * @property integer $organization_id
 * @property string  $task_title
 * @property int $created_at
 * @property int $updated_at

 */
class Task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['event_id','organization_id','task_title','created_at', 'updated_at'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';

    public function members()
    {
        return $this->belongsToMany(User::class,'service_provider_tasks','task_id','user_id')->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function Status()
    {
        return $this->belongsTo(Status::class, 'status');
    }


}
