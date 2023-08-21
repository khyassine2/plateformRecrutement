<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendEmailM extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $compte;
    public $object;
    public $message;
    public $nm;
    public function __construct($compte,$object,$message,$nm)
    {
        $this->compte=$compte;
        $this->object=$object;
        $this->message=$message;
        $this->nm=$nm;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:new Address(Auth::guard('entreprise')->user()->emailEntreprise,Auth::guard('entreprise')->user()->nomEntreprise),
            subject: $this->object,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->nm=='utilisateur'){
            return new Content(
                view: 'mail.mail',
                with:[
                    'message1'=>$this->message,
                    ],
            );
        }else{
            $nomFormation=$this->compte['secteur_activiter']['nomSecteurActiviter'];
            $dureeStage=$this->compte['dureeStage'];
            $typeStage=$this->compte['typeStage'];
            $niveauEtude=$this->compte['niveauEtude'];
            return new Content(
                view: 'mail.mail',
                with:[
                    'message1'=>$this->message,
                    'nomFormation1'=>$nomFormation,
                    'dureeStage1'=>$dureeStage,
                    'typeStage1'=>$typeStage,
                    'niveauEtude1'=>$niveauEtude,
                    ],
            );
        }


    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
