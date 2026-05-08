<?php

namespace App\Mail;

use App\Models\Policy;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PolicyIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $policy;

    /**
     * Create a new message instance.
     */
    public function __construct(Policy $policy)
    {
        $this->policy = $policy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your InsureMate Policy is Ready - ' . $this->policy->policy_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.policy-issued',
            with: [
                'policy' => $this->policy,
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
        $policy = $this->policy;
        // Generate the PDF in memory using the existing document view
        $pdf = Pdf::loadView('documents.policy', compact('policy'));

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Policy_Document_' . $this->policy->policy_number . '.pdf')
                    ->withMime('application/pdf'),
        ];
    }
}
