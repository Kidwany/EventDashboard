<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $job_en
 * @property string $job_ar
 */
class JobTitle extends Model
{
    protected $connection = 'mysql';
    protected $table = 'job_title';

    protected $fillable = ['job_en','job_ar'];
}
