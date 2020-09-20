<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderExperienceDocs extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sp_experience_docs';

    protected $fillable = ['user_id','image_id'];

    public function image()
    {
        return $this->belongsTo(Image::class,'image_id','id')->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

}
