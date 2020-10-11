<?php
/**
 * Created by PhpStorm.
 * User: Kidwany
 * Date: 7/28/2020
 * Time: 3:40 PM
 */

namespace App\Interfaces;


/**
 * Interface Payment
 * @package App\Interfaces
 */
interface Payment
{
    /**
     * @return mixed
     */
    public function basicPaymentProcess();

    /**
     * @return mixed
     */
    public function payWithPromoCode();

    /**
     * @return mixed
     */
    public function reserveAppointment();
}
