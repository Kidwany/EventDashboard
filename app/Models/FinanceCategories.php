<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $url
 * @property string $name
 * @property string $path
 * @property string $alt
 * @property string $title
 * @property string $description
 * @property int $created_at
 * @property int $updated_at

 */
class FinanceCategories extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'finance_categories';

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';


}
