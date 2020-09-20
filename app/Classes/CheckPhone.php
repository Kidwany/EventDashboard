<?php
/**
 * Created by PhpStorm.
 * User: Kidwany
 * Date: 7/31/2020
 * Time: 11:34 PM
 */

namespace App\Classes;


use App\Models\Phone;
use App\User;

class CheckPhone
{
    /**
     * @var
     */
    public $phone;

    /**
     * CheckPhone constructor.
     * @param $phone
     */
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function checkPhoneExistence()
    {
        $user = Phone::where('value', $this->phone)->first();
        if (empty($user))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
