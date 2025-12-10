<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentalReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $subjectLine;

    public function __construct($subject, $content)
    {
        $this->subjectLine = $subject;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.reminder');
    }
}