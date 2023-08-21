<?php

namespace App\Jobs;

use App\Mail\SendEmailM;
use App\Mail\SendEmailOffre as MailSendEmailOffre;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendEmailOffre implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $data;
    public $offre;
    public function __construct($data,$offre)
    {
        $this->data=$data;
        $this->offre=$offre;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->data as $item)
        {
            Mail::to($item->email)->send(new MailSendEmailOffre($item,$this->offre));
        }
    }
}
