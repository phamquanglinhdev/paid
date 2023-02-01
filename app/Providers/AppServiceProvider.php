<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $rm = [];
            $bills = Bill::all();
            foreach ($bills as $bill) {
                if (!$bill->Remaining()) {
                    $rm[] = $bill;
                }
            }
            View::share("_remaining", $rm);
            View::share("_remaining_count", count($rm));

        } catch (\Exception $exception) {

        }
        try {
            $student_count = Student::where("role", "user")->count();
            View::share("_student_count", $student_count);
            $deactivate_bill_count = Bill::where("disable", "1")->orWhere("end", "<", now())->count();
            View::share("_deactivate_bill_count", $deactivate_bill_count);
            $activate_bill_count = Bill::where("disable", "0")->where("end", ">=", now())->count();
            View::share("_activate_bill_count", $activate_bill_count);
        } catch (\Exception $exception) {

        }
        try {
            $total = Bill::sum("amount");
            $from = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $total_in_month = Bill::where("start", ">=", $from)->where("start", "<=", $end)->sum("amount");
            View::share("_total",$total);
            View::share("_total_in_month",$total_in_month);
            $last_from = new Carbon('first day of last month');
            $last_end = new Carbon('last day of last month');
            $total_in_last_month = Bill::where("start", ">=", $last_from)->where("start", "<=", $last_end)->sum("amount");
            View::share("_total_in_last_month",$total_in_last_month);
        } catch (\Exception $exception) {

        }
    }
}
