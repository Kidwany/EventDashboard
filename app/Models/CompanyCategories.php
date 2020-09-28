<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $code
 * @property string $event_id
 * @property int $name
 * @property string $description
 * @property int $is_active
 * @property string $created_at
 * @property string $updated_at
 */

class CompanyCategories extends Model
{
    protected $connection = 'mysql';
    protected $table = 'company_categories';
}
