<?php

namespace App\Jobs;

use App\Mail\ExportEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendExportEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected User   $user,
        protected string $file_name,
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public
    function handle(): void
    {
        Mail::to($this->user)
            ->send(new ExportEmail($this->file_name));
    }
}
