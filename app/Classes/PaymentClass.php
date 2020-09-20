<?php


namespace App\Classes;

use App\Models\Transaction;
use Illuminate\Support\Str;

class PaymentClass
{

    /*****************************************************************************************************************
    * @Function_Description: This Function Make Transaction and Affects Star Balance                                 *
    * @param $order            : Order                                                                               *
    * @param $orderStar        : Star Who Deliver Order                                                              *
    * @param $clientBalance    : Balance Of Client                                                                   *
    * @param $starBalance      : Balance Of Star                                                                     *
    * @param $orderFinance     : Finance Info Of Order Like Order Value, PromoCode, Delivery Value, etc...           *
    * @param $offerOrder       : Order Details Like Star and Client Id's                                             *
    * @return Transaction $starTransaction                                                                           *
    *****************************************************************************************************************/
    public static function makeTransactionForStar($order, $orderStar, $clientBalance, $starBalance, $orderFinance, $offerOrder)
    {

        $starTransaction = new Transaction();
        $starTransaction->order_id = $order->id;
        $starTransaction->user_id = $orderStar;
        $starTransaction->total_discount = 0;
        $starTransaction->transaction_code = '#' . Str::random(5);

        /**
         * Check if Client Balance >= Order Value
         **/
        //return $orderFinance->total;
        if ($clientBalance->amount > $orderFinance->total)
        {
            //return '$clientBalance->amount >= $orderFinance->total';
            $starTransaction->amount = $orderFinance->total;
            $starTransaction->credit_value = $orderFinance->service_value;
            $starTransaction->debit_value = 0;
            $starTransaction->balance_before = $starBalance->amount;
            $starTransaction->balance_after = $starBalance->amount + $orderFinance->service_value;
            $starTransaction->type = 'addition';
            $starTransaction->notes = 'Delivery Fees For Order ' . $offerOrder->order_details;
            $starTransaction->save();
            //Update Star Final Balance
            $starBalance->amount = $starBalance->amount + $orderFinance->service_value;
            $starBalance->credit_value = $starBalance->credit_value + $orderFinance->service_value;
            $starBalance->debit_value = $starBalance->debit_value + 0;
            $starBalance->save();
        }



        /**
         * Check if Client Balance < Order Value
         **/
        elseif ($clientBalance->amount < $orderFinance->total)
        {
            /**
             * Check If Difference Between order value and client balance GREATER than delivery fees
             * Make Transaction with value
             * Put The Difference as debit on star balance
             **/
            //return '$clientBalance->amount < $orderFinance->total';
            if (($orderFinance->total - $clientBalance->amount) > $orderFinance->service_value)
            {
                //return '($orderFinance->total - $clientBalance->amount) > $orderFinance->service_value';
                $debtor = $orderFinance->product_real_price - $orderFinance->service_value;
                $starTransaction->amount = $orderFinance->total;
                $starTransaction->credit_value = 0;
                $starTransaction->debit_value = $debtor;
                $starTransaction->balance_before = $starBalance->amount;
                $starTransaction->balance_after = $starBalance->amount - $debtor;
                $starTransaction->type = 'subtract';
                $starTransaction->notes = 'Delivery Fees For Order ' . $offerOrder->order_details;
                $starTransaction->save();
                //Update Star Final Balance
                $starBalance->amount = $starBalance->amount - $debtor;
                $starBalance->credit_value = $starBalance->credit_value + 0;
                $starBalance->debit_value = $starBalance->debit_value + $debtor;
                $starBalance->save();
            }



            /**
             * Check If Difference Between order value and client balance LESS than delivery fees
             * Make Transaction with value
             * Put The Difference as CREDIT on star balance
             **/
            elseif(($orderFinance->total - $clientBalance->amount) < $orderFinance->service_value)
            {
                //return '($orderFinance->total - $clientBalance->amount) < $orderFinance->service_value';
                $creditor = $orderFinance->service_value - ($orderFinance->total - $clientBalance->amount);
                $starTransaction->amount = $orderFinance->total;
                $starTransaction->credit_value = $creditor;
                $starTransaction->debit_value = 0;
                $starTransaction->balance_before = $starBalance->amount;
                $starTransaction->balance_after = $starBalance->amount + $creditor;
                $starTransaction->type = 'addition';
                $starTransaction->notes = 'Delivery Fees For Order ' . $offerOrder->order_details;
                $starTransaction->save();
                //Update Star Final Balance
                $starBalance->amount = $starBalance->amount + $creditor;
                $starBalance->credit_value = $starBalance->credit_value + $creditor;
                $starBalance->debit_value = $starBalance->credit_value + 0;
                $starBalance->save();
            }
            elseif (($orderFinance->total - $clientBalance->amount) == $orderFinance->service_value)
            {
                //return '($orderFinance->total - $clientBalance->amount) == $orderFinance->service_value';
                $starTransaction->amount = $orderFinance->total;
                $starTransaction->credit_value = 0;
                $starTransaction->debit_value = 0;
                $starTransaction->balance_before = $starBalance->amount;
                $starTransaction->balance_after = $starBalance->amount + 0;
                $starTransaction->notes = 'Delivery Fees For Order ' . $offerOrder->order_details;
                $starTransaction->save();
            }
        }

        return $starTransaction;
    }


    /**
     * @Function_Description: This Function Make Transaction and Affects Client Balance
     * @param $order            : Order
     * @param $orderClient      : Client Who Request Order
     * @param $totalOrderAmount : Total Value Of Order ($acceptedOffer->offer_value) + $input['bill_amount'] + ($orderFinance->minimum_value)
     * @param $orderFinance     : Finance Info Of Order Like Order Value, PromoCode, Delivery Value, etc...
     * @param $promoCode        :
     * @param $offerOrder
     * @param $clientBalance
     * @return Transaction
     */
    public static function makeTransactionForClient($order, $orderClient, $totalOrderAmount, $orderFinance, $promoCode, $offerOrder, $clientBalance)
    {
        $clientTransaction = new Transaction();
        $clientTransaction->order_id = $order->id;
        $clientTransaction->user_id = $orderClient;
        $clientTransaction->transaction_code = '#' . Str::random(5);
        $clientTransaction->amount = $totalOrderAmount;
        $clientTransaction->balance_before = $clientBalance->amount;
        $clientTransaction->notes = 'Amount of Order ' . $offerOrder->order_details;

        //check if promo code existed
        if ($orderFinance->promo_code_id)
        {
            if ($clientBalance->amount < $totalOrderAmount)
            {
                //return '$clientBalance->amount < $totalOrderAmount';
                $clientTransaction->total_discount = $promoCode->discount_amount;
                $clientTransaction->balance_after = 0;
                $clientTransaction->save();
                //Update Balance
                $clientBalance->amount = 0;
                $clientBalance->save();
            }

            else
            {
                //return '$clientBalance->amount < $totalOrderAmount else';
                $clientTransaction->balance_after = ($clientBalance->amount) - $totalOrderAmount;
                $clientTransaction->total_discount = $promoCode->discount_amount;
                $clientTransaction->save();
                //Update Balance
                $clientBalance->amount = ($clientBalance->amount) - $totalOrderAmount;
                $clientBalance->save();
            }
            //return '$orderFinance->promo_code_id';
            /*$clientTransaction->total_discount = $promoCode->discount_amount;
            $clientTransaction->promo_code_id = $promoCode->id;
            $clientTransaction->notes = 'Discount From Promo Code ' . $promoCode->code;
            $clientTransaction->save();*/

        }

        else
        {
            if ($clientBalance->amount < $totalOrderAmount)
            {
                //return '$clientBalance->amount < $totalOrderAmount';
                $clientTransaction->balance_after = 0;
                $clientTransaction->total_discount = 0;
                $clientTransaction->save();
                //Update Balance
                $clientBalance->amount = 0;
                $clientBalance->save();
            }

            else
            {
                //return '$clientBalance->amount < $totalOrderAmount else';
                $clientTransaction->balance_after = ($clientBalance->amount) - $totalOrderAmount;
                $clientTransaction->total_discount = 0;
                $clientTransaction->save();
                //Update Balance
                $clientBalance->amount = ($clientBalance->amount) - $totalOrderAmount;
                $clientBalance->save();
            }
            //return '$orderFinance->promo_code_id else';
            /*$clientTransaction->total_discount = 0;
            $clientTransaction->notes = 'Amount of Order ' . $offerOrder->order_details;
            $clientTransaction->save();*/
        }

        return $clientTransaction;
    }


    public function checkPromoCode()
    {

    }


}
