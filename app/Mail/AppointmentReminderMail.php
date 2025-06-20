<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }
    
    public function build()
    {
        return $this->subject('Upcoming Appointment Reminder')
                    ->markdown('emails.reminder.index')
                    ->with([
                        'appointment' => $this->appointment
                    ]);
    }
}
