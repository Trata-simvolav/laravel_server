<?php

namespace App\Mail;

use App\Models\Api\V1\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class RegistrationConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(

    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // from: new Address('aprojectev@gmail.com', 'Admin TIL'),
            subject: 'Order Shipped',
        );
    }

    /**
     * Get the message content definition.
     */
    public function sendSampleEmail()
    {
        $recipient = 'atamurattemirlan7@gmail.com';
        
        $response = Http::post("https://api.mailgun.net/v3/sandbox4067fbac0df746a1ad9a5791cb078d60.mailgun.org/messages", [
            'auth' => ['api', '721286c7f26b93d05c630111e5ea2de4-51356527-ff5b99fc'],
            'form_params' => [
                'from' => 'aprojectev@gmail.com',
                'to' => $recipient,
                'subject' => 'Sample Email',
                'html' => view('emails.registration_confirmation')->render(),
            ],
        ]);
        
        if ($response->successful()) {
            return "Email sent successfully!";
        } else {
            return "Failed to send email.";
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
