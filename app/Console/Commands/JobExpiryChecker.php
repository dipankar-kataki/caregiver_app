<?php

namespace App\Console\Commands;

use App\Common\JobStatus;
use App\Models\JobByAgency;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class JobExpiryChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $job_details = DB::table('job_by_agencies')->where('is_activate', 1)->get();

        foreach( $job_details as $key => $item){

            $converted_end_time = strtotime($item->end_date_of_care.' '.date_create($item->end_time)->format('H:i'));
            $current_time = strtotime(date('Y-m-d H:i'));
            
            $diff_in_minutes = floor( ($current_time - $converted_end_time) / (60 ));
            
            /*************************************** 
                For future reference ===> 

                If $diff_in_minutes > 0 it means Current time has passed the end time;

                if $diff_in_minutes < 0 it means End time has not arrived yet. 
            
            ******************************************/

            if($diff_in_minutes > 0){ 
                DB::table('job_by_agencies')->where('is_activate', 1)->update([
                    'is_activate' => 0,
                    'job_status' => JobStatus::Expired,
                    'is_job_expired' => 1
                ]);

                DB::table('accepted_jobs')->where('job_by_agencies_id', $item->id)->update([
                    'is_activate' => 0,
                ]);
            }
        }
    }
}
