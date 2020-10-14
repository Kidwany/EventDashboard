<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 * @property integer $id
 * @property integer $group_id
 * @property integer $task_id
 * @property string  $status_id
 * @property integer $created_by
 * @property integer $updated_by
 *
 */
class UserGroupTasks extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'user_groups_tasks';

}
