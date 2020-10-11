<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\PaypalPayment;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PHPUnit\TextUI\ResultPrinter;
use Illuminate\Support\Facades\Crypt;

class PaypalController extends Controller
{

    private $apiContext;
    private $secret;
    private $client_id;
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
        //$this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        //$this->apiContext->setConfig(config('paypal.settings'));
    }

    public function payWithPayPal(Request $request)
    {
        $price = $request->price;
        $name = $request->name;
        $package_id = $request->package_id;

        //Set Payer
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        //Items
        $item = new Item();
        $item->setName($name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice($price);

        //Item List
        $itemList = new ItemList();
        $itemList->setItems(array($item));

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($name)
            ->setInvoiceNumber(uniqid());


        //$baseUrl = url();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://localhost/event_dashboard/public/package/subscription-status?package_id=" . $package_id)
            ->setCancelUrl("http://localhost/event_dashboard/public/package/subscription-cancelled");


        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        try {
            $payment->create($this->apiContext);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        }

        $approvalUrl = $payment->getApprovalLink();

        return redirect($approvalUrl);

    }

    public function status(Request $request)
    {
        if (empty($request->input('PayerID') || empty($request->input('token')) ))
        {
            return redirect()->back()->with('exception', 'Payment Failed');
        }

        if (empty($request->input('PayerID') || empty($request->input('token')) ))
        {
            return redirect()->back()->with('exception', 'Payment Failed');
        }

        $paypal_payment = new PaypalPayment();
        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $paypal_payment->getApiContext());

        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        $result = $payment->execute($execution, $paypal_payment->getApiContext());

        if ($result->getState() == 'approved')
        {
            return redirect('package')->with('create', 'Your Consultation Confirmed Successfully and sent To Doctor');
        }

        echo 'Failed Payment Process';
        die($result);

    }

    public function cancelled()
    {
        return 'cancelled';
    }
}
