<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscordController extends Controller
{
    public static function notification($student, $amount, $end): \Illuminate\Http\Client\Response
    {
        return Http::post('https://discord.com/api/webhooks/1069944620257120336/ZtyG5RBfoypXtLlHtVduDoUAjlZ9zCJH5-F-_sg-pC10O9lTiLtR90h-1K5L7EJ0EGrz', [
            'content' => "Thông báo sắp đến hạn đóng học phí",
            'embeds' => [
                [
                    'title' => "$student",
                    'description' => "Số tiền:$amount,\n Ngày hết hạn: $end",
                    'color' => '7506394',
                    'link' => 'https://fb.me/linhcuenini',
                    'avatar' => 'http://anhlondep.xyz/wp-content/uploads/2022/08/anh-lon-13.jpg',
                ]
            ],
        ]);

    }
}
