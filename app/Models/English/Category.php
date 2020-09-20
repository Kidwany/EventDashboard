<?php

namespace App\Models\English;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $category_id
 * @property string $title
 * @property string $slug
 * @property string $description
 */

class Category extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'category';

    protected $fillable = ['category_id','title','slug','description'];
}
