<?php

namespace App\Jobs;

use App\Mail\JobAppliedMail;
use App\Models\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApplicationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $applicationId;

    /**
     * Create a new job instance.
     */
    public function __construct($applicationId)
    {
        $this->applicationId = $applicationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mail::to($this->application->user->email)
        //     ->send(new JobAppliedMail($this->application->job, $this->application->user));

         $application = Application::with('job', 'user')->find($this->applicationId);

        if (!$application) {
            return;
        }

        Mail::to($application->user->email)
            ->send(new JobAppliedMail(
                $application->job, 
                $application->user));
    }
}