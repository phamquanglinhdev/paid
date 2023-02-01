<?php

use App\Http\Controllers\Admin\DiscordController;
use App\Models\Bill;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(backpack_url("/"));
});
Route::get("/cron", function () {
    $bills = Bill::all();
    foreach ($bills as $bill) {
        if (!$bill->Remaining()) {
            $student = $bill->Student->name;
            $end = date('d-m-Y', strtotime($bill->end));
            $amount = number_format($bill->amount) . " đ";
            DiscordController::notification($student, $amount, $end);
        }
    }
});
