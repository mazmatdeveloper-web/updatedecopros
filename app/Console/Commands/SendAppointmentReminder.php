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
//     $startWindow = now()->addMinutes(9);
//     $endWindow = now()->addMinutes(11);

// $appointments = Appointment::where('reminder_sent', false)
//     ->whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', start_time), '%Y-%m-%d %H:%i:%s') BETWEEN ? AND ?", [$startWindow, $endWindow])
//     ->get();

        $now = Carbon::now();
        $oneDayFromNow = $now->copy()->addDay();

        // Calculate the 24-hour window (1 day before appointment)
        $startWindow = $oneDayFromNow;
        $endWindow = $oneDayFromNow->copy()->addMinutes(5); // Small buffer period

        $appointments = Appointment::where('reminder_sent', false)
            ->whereRaw("
                STR_TO_DATE(
                    CONCAT(appointment_date, ' ', start_time), 
                    '%Y-%m-%d %H:%i:%s'
                ) BETWEEN ? AND ?", 
                [$startWindow, $endWindow]
            )
            ->with('customer') // Eager load customer relationship
            ->get();

    \Log::info('App: ' . $appointments);



    foreach ($appointments as $appointment) {
        \Log::info("Preparing 24-hour reminder for: {$appointment->customer->email}");
    
        try {
            Mail::to($appointment->customer->email)
                ->send(new AppointmentReminderMail($appointment));
            
            $appointment->update([
                'reminder_sent' => true,
                'reminder_sent_at' => now() // Optional timestamp
            ]);
            
            \Log::info("Successfully sent 24-hour reminder to: {$appointment->customer->email}");
            
        } catch (\Exception $e) {
            \Log::error("Reminder failed for {$appointment->customer->email}: " . $e->getMessage());
        }
    }
    
    $this->info('Reminder emails sent.');
// \Log::info('SendAppointmentReminder IS RUNNING at ' . now());
}

}
