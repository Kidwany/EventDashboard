<?php


namespace App\Classes;


use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Order_feedback;
use App\Models\Star_rate_note;
use App\Models\Total_of_user_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Rate
{

    public function rate(Request $request)
    {
        $input =  $request->all();
        $rateOwnerUser = Auth::user();
        $orderDetails = Order_detail::with('order')->where('order_id', $input['order_id'])->first();
        $order = Order::with('orderFeedback')->find($input['order_id']);

        //if authenticated user is star
        if ($orderDetails->star_id == $rateOwnerUser->id)
        {
            //Update Order Feed Back
            $order->orderFeedback()->update([
                'from_star_to_client_rate'  =>  $input['rate'],
                'from_star_to_client_note_id' => $input['note_id']
            ]);
            //$notes = Star_rate::with('starRateNote')->where('star_number', $input['rate'])->get();
            $notes = Star_rate_note::where('star_rate_id', $input['rate'])->get();
            $orderFeedback = Order_feedback::where('order_id', $order->id)->first();

            //Get All Orders Of Rated Client
            $clientOrders = Order_detail::where('user_id', $orderDetails->user_id)->get();

            //Array Of Orders Related To Order Client Owner
            $clientOrdersIds = [];
            foreach ($clientOrders as $clientOrder)
            {
                array_push($clientOrdersIds, $clientOrder->order_id);
            }


            //Get Count Of Orders Which Rated Related To Client
            $clientRatedOrdersCount = Order_feedback::with('complaint')
                ->whereIn('order_id', $clientOrdersIds)
                ->where('from_star_to_client_rate', '!=', null)
                ->count();

            $clientTotalOrders = Total_of_user_order::with('user')->where('user_id', $rateOwnerUser->id)->first();
            //((Overall Rating * Total Rating) + new Rating) / (Total Rating + 1)
            return $clientTotalOrders -> over_all_rate = (($clientTotalOrders->over_all_rate * $clientRatedOrdersCount) +  $input['rate']) / $clientRatedOrdersCount;
            $clientTotalOrders->save();
            return response()->json([
                'success' => 'Star Rated Client Successfully',
                'selected_note' => $orderFeedback->from_star_to_client_note_id,
                'notes' => $notes
            ], 200);
        }

        //if authenticated user is client
        elseif ($orderDetails->user_id == $rateOwnerUser->id)
        {
            $order->orderFeedback()->update([
                'from_client_to_star_rate'  =>  $input['rate'],
                'from_client_to_star_note_id' => $input['note_id']
            ]);
            $notes = Star_rate_note::where('star_rate_id', $input['rate'])->get();
            $orderFeedback = Order_feedback::where('order_id', $order->id)->first();
            return response()->json([
                'success' => 'Client Rated Star Successfully',
                'selected_note' => $orderFeedback->from_client_to_star_note_id,
                'notes' => $notes
            ], 200);
        }

        else
        {
            return response()->json(['error' => 'Can\'t Rate'], 422);
        }
    }


}
