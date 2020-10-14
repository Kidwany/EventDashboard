<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $users_no
 * @property string $events_no
 * @property int $views_no
 * @property string $price
 * @property int $notes
 * @property string $is_active
 * @property string $is_main_package
 */

class ProfileViews extends Model
{
    protected $connection = 'mysql';
    protected $table = 'profile_views';
}
