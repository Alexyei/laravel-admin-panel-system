<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteTempImgs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:imgs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command delete unused images';

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
        $images_in_dir = array_diff(scandir(public_path('/storage/uploads/')), array('..', '.'));
        foreach ($images_in_dir as $img) {
            File::delete(public_path('/storage/uploads/' . $img));
        }
        return 0;
    }
}
