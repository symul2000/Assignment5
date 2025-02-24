<?php

namespace App\Jobs;

use App\Mail\RentalConfirmation;
use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRentalEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $rental;

    /**
     * Create a new job instance.
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send email to customer
        Mail::to($this->rental->user->email)->send(new RentalConfirmation($this->rental));

        // Send email to admin
        Mail::to('admin@example.com')->send(new RentalConfirmation($this->rental));
    }
}

