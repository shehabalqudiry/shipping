<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Notifications\NewUserNotification;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public static function NewUserRegisteredNotification($para)
    {
        $userSchema = Admin::get();

        $data = [
            'user_id' => $para['user_id'],
            'body'    => 'مستخدم جديد : ' . $para['user_name'],
            'link'    => $para['link'],
        ];

        foreach ($userSchema as $user) {
            Notification::send($user, new NewUserNotification($data));
        }
    }


    public static function NewOrderNotification($para)
    {
        $userSchema = Admin::get();

        $data = [
            'user_id'       => $para['user_id'],
            'type'          => $para['type'],
            'shipment_id'   => $para['shipment_id'] ?? '',
            'body'          => $para['body'],
        ];

        foreach ($userSchema as $user) {
            Notification::send($user, new OrderNotification($data));
        }
    }
}
