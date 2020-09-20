<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $job_title_id
 */

class ServiceProviderJobs extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sp_jobs';

    protected $fillable = ['user_id','job_title_id'];


}
