<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $id
 * @property integer $user_id
 * @property string $job_title
 * @property string $company
 * @property string $start_date
 * @property string $end_date
 * @property string $is_current
 * @property string $job_description
 */

class ServiceProviderExperience extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'sp_experience';

    protected $dates = ['end_date', 'start_date'];

    /**
     * @var array
     */
    protected $fillable = ['user_id','job_title','company','start_date','end_date','is_current','job_description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function docs()
    {
        return $this->hasMany(ServiceProviderExperienceDocs::class,'sp_experience_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doc()
    {
        return $this->belongsTo(ServiceProviderExperienceDocs::class,'sp_experience_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this
            ->belongsToMany(Image::class, 'sp_experience_docs', 'sp_experience_id', 'image_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this
            ->belongsToMany(File::class, 'sp_experience_docs', 'sp_experience_id', 'file_id');
    }
}
