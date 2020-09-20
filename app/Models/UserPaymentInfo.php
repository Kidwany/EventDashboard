<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property integer $user_id
 * @property string $bank
 * @property string $ipan_no
 */
class UserPaymentInfo extends Model
{
    protected $connection = 'mysql';
    protected $table = 'user_payment_info';

    protected $fillable = ['user_id','bank','ipan_no'];


}
