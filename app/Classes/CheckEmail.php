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

class CheckEmail
{
    /**
     * @var
     */
    public $email;

    /**
     * CheckPhone constructor.
     * @param $phone
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function checkEmailExistence()
    {
        $user = User::where('email', $this->email)->first();
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
