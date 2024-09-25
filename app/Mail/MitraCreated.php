<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MitraCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $files;

    public function __construct($data, $files)
    {
        $this->data = $data;
        $this->files = $files;
    }

    public function build()
    {
        $email = $this->subject('Create NIK Mitra Jogja')
                      ->view('emails.mitra_created')
                      ->with('data', $this->data);

        foreach ($this->files as $file) {
            $email->attach($file->getPathname(), [
                'as' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
            ]);
        }

        return $email;
    }
}
