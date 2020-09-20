<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mysql';
    protected $table = 'category';

    protected $fillable = ['created_at','updated_at'];
    public function category_ar()
    {
        return $this->hasOne(\App\Models\Arabic\Category::class, 'category_id');
    }

    public function category_en()
    {
        return $this->hasOne(\App\Models\English\Category::class, 'category_id');
    }
}
