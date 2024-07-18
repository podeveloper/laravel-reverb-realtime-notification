<?php

namespace App\Jobs;

use App\Events\ExportPdfStatusUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessPdfExport implements ShouldQueue
{
    use Queueable;

    protected User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        event(new ExportPdfStatusUpdated($this->user, [
            'message' => 'Exporting...',
        ]));

        sleep(5);

        event(new ExportPdfStatusUpdated($this->user, [
            'message' => 'Complete!',
            'link'    => Storage::disk('public')->url('users.pdf'),
        ]));
    }
}
