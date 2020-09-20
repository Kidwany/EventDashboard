<?php

namespace App\Models\Arabic;

use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $category_id
 * @property string $title
 * @property string $slug
 * @property string $description
 */

class Category extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'category';

    protected $fillable = ['category_id','title','slug','description'];
}
