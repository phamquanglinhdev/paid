<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscordController extends Controller
{
    public static function notification($students): \Illuminate\Http\Client\Response
    {
        return Http::post(env("DISCORD_WEBHOOK"), [
            'content' => "Thông báo sắp đến hạn đóng học phí",
            'embeds' => $students,
        ]);

    }
}
