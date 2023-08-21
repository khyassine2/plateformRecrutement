<?php

namespace App\Mail;

use App\Models\Offre;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailOffre extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public $offre;
    public $offre1;
    public function __construct($data,$offre)
    {
        $this->data=$data;
        $this->offre=$offre;
        $this->offre1=$offre=Offre::find($this->offre);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        
        return new Envelope(
            from:new Address($this->data->email,$this->data->nomUtilisateur),
            subject: "Nouvelle offres de ".$this->offre1->typeOffre." de ".$this->offre1->titreOffre." publiées.Postulez en premier!!"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.AlertOffre',
            with:[
                'idOffre'=>$this->offre1->idOffre,
                'titreOffre'=>$this->offre1->titreOffre,
                'descriptionOffre'=>$this->offre1->descriptionOffre,
                'competenceRequise'=>$this->offre1->competenceRequise,
                'RemunurationPropose'=>$this->offre1->RemunurationPropose,
                'typeOffre'=>$this->offre1->typeOffre,
                ],
        );
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
