<?php


namespace App\Classes;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Paypal\Rest\ApiContext;
use Paypal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PHPUnit\TextUI\ResultPrinter;


abstract class PaypalPayment
{

    private $apiContext;
    private $secret;
    private $client_id;
    private $consultationId;
    private $price;
    private $paymentTitle;
    private $currency;
    private $statusUrl;
    private $cancelUrl;

    public function __construct($consultationId, $price, $currency, $paymentTitle, $statusUrl, $cancelUrl)
    {
        $this->price = $price;
        $this->currency = $currency;
        $this->paymentTitle = $paymentTitle;
        $this->consultationId = $consultationId;
        $this->statusUrl = $statusUrl;
        $this->cancelUrl = $cancelUrl;

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
        //$this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        //$this->apiContext->setConfig(config('paypal.settings'));
    }


    public function payWithPayPal(Request $request)
    {
        $price = $request->price;
        $name = $request->title;
        $consultationId = $request->consultation_id;
        $this->consultationId = $request->consultation_id;

        //Set Payer
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        //Items
        $item1 = new Item();
        $item1->setName($name)
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice($price);

        //Item List
        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($name)
            ->setInvoiceNumber(uniqid());


        //$baseUrl = url();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://localhost/conzil/public/status")
            ->setCancelUrl("http://localhost/conzil/public/cancelled");


        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        try {
            $payment->create($this->apiContext);
            $consultation = Consultation::find($consultationId);
            $consultation->status_id = 14;
            $consultation->save();

        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            die($ex);
        }

        $approvalUrl = $payment->getApprovalLink();

        return redirect($approvalUrl);
    }

    abstract function status();

    abstract function cancelled();

}
