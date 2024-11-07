<?php

namespace App\Jobs;

use App\Mail\SeminarParticipantEmail;
use App\Models\Form;
use Illuminate\Support\Facades\Mail;
use App\Mail\HandsOnRegistrationMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPaidBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $form;
    /**
     * Create a new job instance.
     */
    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->form->email)->send(new SeminarParticipantEmail($this->form));
    }
}
