<?php


namespace App\Classes;

use App\Models\Consultation;
use Paypal\Rest\ApiContext;
use Illuminate\Support\Facades\Auth;
use Paypal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use App\Models\PaymentSetting;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PHPUnit\TextUI\ResultPrinter;


class PaypalPayment
{

    /**
     * @var ApiContext
     */
    private $apiContext;
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $secret;
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $client_id;

    /**
     * PaypalPayment constructor.
     */
    public function __construct()
    {
        if (config('paypal.settings.mode') == 'live')
        {
            $this->client_id = config('paypal.live_client_id');
            $this->secret = config('paypal.live_secret');
        }
        else
        {
            $this->client_id = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');
        }
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->client_id,// ClientID
                $this->secret     // ClientSecret
            )
        );
        $this->apiContext->setConfig(config('paypal.settings'));
    }

    /**
     * @return ApiContext
     */
    public function getApiContext(): ApiContext
    {
        return $this->apiContext;
    }


    /**
     * @param $name
     * @param $price
     * @return null|string
     */
    public function payWithPayPal($name, $price)
    {

        //Set Payer
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        //Items
        $item1 = new Item();
        $item1->setName($name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice($price * 0.27);

        //Item List
        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($price * 0.27);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($name)
            ->setInvoiceNumber(uniqid());


        $redirectUrls = new RedirectUrls();

        $redirectUrls->setReturnUrl("http://localhost/event_dashboard/public/package/subscription-status")
            ->setCancelUrl("http://localhost/event_dashboard/public/package/subscription-cancelled");


        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->apiContext);

        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            die($ex);
        }

        $approvalUrl = $payment->getApprovalLink();

        return  $approvalUrl;

    }

}
