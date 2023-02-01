<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscordController extends Controller
{
    public static function notification($student, $amount, $end): \Illuminate\Http\Client\Response
    {
        return Http::post(env("DISCORD_WEBHOOK"), [
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
