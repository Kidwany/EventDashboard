<?php


namespace App\Classes;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

/**
 * Class NotificationClass
 * @package App\Classes
 */
class NotificationClass
{

    public static function sendPushNotification($to = '', $data = array())
    {
        $api_key = 'AAAAzahjYcI:APA91bEX3xWuvDeQmrKbmyD-x3bAr7qUZ7l0QqytQM4IlaLi_4PpeFhgn7X1rWknIEwQY8igQtDeUdkTQpQ-qDP4Sh7j4ePaBQZt0NEVO7rYlu-RAZ82Se7nK0_9vSDj0WHYQafboa9K';
        $fields = array('to' => $to, 'notification' => $data);

        $headers = array('Authorization: key=' . $api_key, 'Content-Type: application/json');

        $url = 'https://fcm.googleapis.com/fcm/send';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        curl_close($ch);

        return json_encode($result, true);
    }

    /**
     * @param $type
     * @param $notifiableType
     * @param $notifiable_id
     * @param $sent_from
     * @param $title
     * @param $data
     * @param null $order_id
     * @return \App\Models\Notification
     *
     */
    public static function storeNotification($type, $notifiableType, $notifiable_id, $sent_from, $title, $data, $consultation_id = null)
    {
        $notification = new \App\Models\Notification();
        $notification->type = $type;
        $notification->notifiable_type = $notifiableType;
        $notification->title = $title;
        $notification->notifiable_id = $notifiable_id;
        $notification->sent_from = $sent_from;
        $notification->consultation_id = $consultation_id;
        $notification->data = $data;
        $notification->save();
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/hemmtk-firebase-adminsdk-gufet-035d61ef62.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://hemmtk.firebaseio.com')
            ->create();
        $database = $firebase->getDatabase();
        $database
            ->getReference('Notifications/'.$notifiable_id)
            ->push([
                'title' => $title,
                'body' => 'لديك مهمه جديده من فاعليه '.$data ,
                'createdDate' => Carbon::now(),
                'icon'=>URL::to('/dashboard/assets/images/icon/tasks.bd1b6b37.svg'),
                'is_read'=>'false',
                'type'=>$type,
            ]);



        return $notification;
    }

    /**
     * @param $send_to_token
     * @param $notification_title
     * @param $notification_data
     * @param $notificationType
     * @param $clickActivity
     */
    public static function fcmPushNotification($send_to_token, $notification_title, $notification_data, $notificationType, $clickActivity)
    {
        $server_key = 'AAAAhfHMADg:APA91bG2eInTDG6a48Ni414OTT9c3JNWHecz64GVSda5z96jFDPh_4z-LaVcAQOHrVfPsK7kziutl6daVWT8yTlc7aqMDc_oc7R2J6rOtxxnrHahPQIndfDIeEpfk9256Ypj8LVA5XMf';
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
        $message = new Message();
        $message->setPriority('high');
        $message->addRecipient(new Device($send_to_token));
        $message->setNotification(new Notification($notification_title, $notification_data))
                ->setData([
                    'type' => $notificationType,
                    'click_activity' => $clickActivity,
                ]);
        $response = $client->send($message);
    }


    public static function multiplePushNotification($title, $description, $tokens = array())
    {
        $server_key = 'AAAA09s3CB0:APA91bGeTqBoiqhWyEoX89TplBf1khWtQxgq1R834bUSpKguD-Zy2pJqZqlmuWXRxdic3PlRHGoLc0OdadICyufD8CHsMP0R_Km5pV41tu_SKdG5BwktQ_HV7ze_nVFUEwHDYjqn3mXo';
        $client = new \GuzzleHttp\Client();
        foreach ($tokens as $token)
        {
            $request = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
                'headers' => [
                    "Authorization" => "key=" . $server_key,
                    "content-type" => "application/json"
                ],
                'json' =>
                    [
                        'data' => [
                            "title" => $title,
                            "content" => $description,
                            //"imageUrl" => "http://h5.4j.com/thumb/Ninja-Run.jpg",
                            //"gameUrl" => "https://h5.4j.com/Ninja-Run/index.php?pubid=noad"
                        ],
                        'to' => $token
                    ]
            ]);
        }
    }

}
