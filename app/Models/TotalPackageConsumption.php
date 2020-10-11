<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $total_events
 * @property string $total_views
 * @property int $total_accounts
 * @property string $organization_id
 * @property int $notes
 * @property string $is_active
 * @property string $is_main_package
 */

class TotalPackageConsumption extends Model
{
    protected $connection = 'mysql';
    protected $table = 'total_package_consumption';
}
