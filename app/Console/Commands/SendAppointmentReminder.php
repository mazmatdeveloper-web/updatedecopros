<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;
use Carbon\Carbon;

class SendAppointmentReminder extends Command
{
    protected $signature = 'appointment:send-reminder';
    protected $description = 'Send appointment reminder email one day before the appointment date';

    public function handle()
{
    $startWindow = now()->addMinutes(9);
    $endWindow = now()->addMinutes(11);

$appointments = Appointment::where('reminder_sent', false)
    ->whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', start_time), '%Y-%m-%d %H:%i:%s') BETWEEN ? AND ?", [$startWindow, $endWindow])
    ->get();

$now = Carbon::now();

        // Look for appointments starting in the next 5 minutes
        $startWindow = $now;
        $endWindow = $now->copy()->addMinutes(5);

        $appointments = Appointment::where('status', 'pending')
            ->whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', start_time), '%Y-%m-%d %H:%i:%s') BETWEEN ? AND ?", [
                $startWindow,
                $endWindow
            ])
            ->get();

    \Log::info('App: ' . $appointments);



        foreach ($appointments as $appointment) {
            \Log::info('Sending reminder to: ' . $appointment->customer->email);
        
            try {
                Mail::to($appointment->customer->email)
                    ->send(new AppointmentReminderMail($appointment));
            } catch (\Exception $e) {
                \Log::error('Failed to send reminder email: ' . $e->getMessage());
            }
        
            \Log::info('Reminder sent to: ' . $appointment->customer->email);
        
            $appointment->update(['reminder_sent' => true]);
        }

    $this->info('Reminder emails sent.');
// \Log::info('SendAppointmentReminder IS RUNNING at ' . now());
}

}
