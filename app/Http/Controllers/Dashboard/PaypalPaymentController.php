<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Balance;
use App\Models\DoctorAppointment;
use Illuminate\Http\Request;
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

class PaymentController extends Controller
{
    private $apiContext;
    private $secret;
    private $client_id;
    private $consultationId;

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
        //$this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        //$this->apiContext->setConfig(config('paypal.settings'));
    }

    public function payWithPayPal(Request $request)
    {
        $input = $request->all();

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
        $redirectUrls->setReturnUrl("https://www.konsilmed.com/status")
            ->setCancelUrl("https://www.konsilmed.com/cancelled");


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

        return redirect($approvalUrl);

    }

    public function status(Request $request)
    {
        if (empty($request->input('PayerID') || empty($request->input('token')) ))
        {
            return redirect()->back()->with('exception', 'Payment Failed');
        }

        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved')
        {
            return redirect(adminUrl('package'))->with('create', 'تمت عملية الدفع بنجاح انت الان مشترك في الباقة');
        }

        echo 'Failed Payment Process';
        die($result);

    }

    public function cancelled()
    {
        return redirect('package')->with('exception', 'حدث خطأ في عملية الدفع ... من فضلك حاول مرة اخرى');
    }
}
