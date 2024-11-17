<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Student $student
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Successful - University X',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-successful',
            with: [
                'studentName' => $this->student->name,
                'studentId' => $this->student->nomor_induk,
                'faculty' => $this->student->faculty->name,
                'majorStudy' => $this->student->major_study,
            ],
        );
    }
}