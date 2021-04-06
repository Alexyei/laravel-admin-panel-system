<?php

namespace App\Console\Commands;

use App\Models\DailyUserAction;
use App\Models\ResetPassword;
use App\Models\VerifyCabinet;
use App\Models\VerifyUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteTempRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:temp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command delete unused records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DailyUserAction::where('created_at', '<=', now()->subDay())->delete();

        VerifyUser::where('created_at', '<=', now()->subDay())->delete();
        ResetPassword::where('created_at', '<=', now()->subDay())->delete();
        VerifyCabinet::where('created_at', '<=', now()->subDay())->delete();
        return 0;
    }
}
