<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class  ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $model;
   
    public function __construct($model)
    {
        $this->model  = $model;
    }

    public function build()
    {
        return $this->subject($this->model->subject)
                    ->view('emails.contact_us')
                    ->with([
                        'model'  => $this->model,    
                    ]);
    }
}
