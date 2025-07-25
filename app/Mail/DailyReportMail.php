<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $filePath,
        public string $reportDate
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Ежедневный отчет Обьектов внедрения и их представителей за {$this->reportDate}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily_report',
            with: [
                'reportDate' => $this->reportDate
            ]
        );
    }

    public function attachments(): array
    {
        return [
            [
                'path' => $this->filePath,
                'as' => basename($this->filePath),
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
        ];
    }
}
