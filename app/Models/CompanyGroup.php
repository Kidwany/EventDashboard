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

class CompanyGroup extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'company_groups';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'company_group_members','group_id','member_id')->withTimestamps();
    }
}
