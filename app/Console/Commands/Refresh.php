<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\DiscordController;
use App\Models\Bill;
use Illuminate\Console\Command;

class Refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bills = Bill::all();
        foreach ($bills as $bill) {
            if (!$bill->Remaining()) {
                $student = $bill->Student->name;
                $end = date('d-m-Y', strtotime($bill->end));
                $amount = number_format($bill->amount) . " đ";
                DiscordController::notification($student, $amount, $end);
            }
        }
    }
}
