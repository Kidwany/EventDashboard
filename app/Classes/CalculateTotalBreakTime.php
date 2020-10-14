<?php
/**
 * Created by PhpStorm.
 * User: Kidwany
 * Date: 7/31/2020
 * Time: 11:34 PM
 */

namespace App\Classes;


use App\Models\Phone;
use App\Models\UserRest;
use App\User;
use Carbon\Carbon;

class CalculateTotalBreakTime
{
    /**
     * @var
     */
    public $user_id;
    /**
     * @var
     */
    public $event_id;
    /**
     * @var
     */
    public $group_id;

    /**
     * CalculateTotalRestTime constructor.
     * @param $user_id
     * @param $event_id
     * @param $group_id
     */
    public function __construct($user_id, $event_id, $group_id)
    {
        $this->user_id = $user_id;
        $this->event_id = $event_id;
        $this->group_id = $group_id;
    }


    /**
     * @param $user_id
     * @param $event_id
     * @param $group_id
     * @return mixed
     */
    public static function calculateTotal($user_id, $event_id, $group_id)
    {
        $rest_times = UserRest::where('event_id', $event_id)
            ->where('user_id', $user_id)
            ->where('group_id', $group_id)
            ->get();

        $minutes = 0;

        if (count($rest_times) > 0)
        {
            foreach ($rest_times as $rest_time)
            {
                if (date('d', strtotime($rest_time->rest_start)) == date('d', strtotime(Carbon::today())))
                {
                    $start_time = Carbon::parse($rest_time->rest_start);
                    $end_time = Carbon::parse($rest_time->rest_end);
                    $minutes += $start_time->diffInMinutes($end_time);
                }
            }
        }

        return $minutes;
    }

    /**
     * @param $user_id
     * @param $group_id
     * @return int
     */
    public static function calculateTotalByGroup($user_id, $group_id)
    {
        $rest_times = UserRest::
            where('user_id', $user_id)
            ->where('group_id', $group_id)
            ->get();

        $minutes = 0;

        if (count($rest_times) > 0)
        {
            foreach ($rest_times as $rest_time)
            {
                if (date('d', strtotime($rest_time->rest_start)) == date('d', strtotime(Carbon::today())))
                {
                    $start_time = Carbon::parse($rest_time->rest_start);
                    $end_time = Carbon::parse($rest_time->rest_end);
                    $minutes += $start_time->diffInMinutes($end_time);
                }
            }
        }

        return $minutes;
    }

    /**
     * @param $user_id
     * @param $event_id
     * @return int
     */
    public static function calculateTotalByEvent($user_id, $event_id)
    {
        $rest_times = UserRest::
        where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->get();

        $minutes = 0;

        if (count($rest_times) > 0)
        {
            foreach ($rest_times as $rest_time)
            {
                if (date('d', strtotime($rest_time->rest_start)) == date('d', strtotime(Carbon::today())))
                {
                    $start_time = Carbon::parse($rest_time->rest_start);
                    $end_time = Carbon::parse($rest_time->rest_end);
                    $minutes += $start_time->diffInMinutes($end_time);
                }
            }
        }

        return $minutes;
    }
}
