<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\diegopenavicente\PaymentNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendBillingCycleEmails extends Command
{
    protected $signature = 'emails:send-billing-cycle';

    protected $description = 'Send emails to users based on their billing cycles';

    public function handle()
    {   //get users with role client
        $users = User::where('role', 'CLIENT')->whereMonth('created_at','<',Carbon::now()->month)->get();

        foreach ($users as $user) {
            $today = Carbon::now();

            Log::info('Sending email to ' . $user->email);
            // Check if it's the correct day and time for sending emails
            if (($user->billing_cycle == 'MONTHLY' && $user->billing_day == $today->day && $today->format('H:i') == '11:15') ||
                ($user->billing_cycle == 'YEARLY' && $user->billing_day == $today->day && $user->billing_month == $today->month && $today->format('H:i') == '11:15')) {
                    
                $mailable = new PaymentNotification($user->name, $user->language, $user->gross_amount);
                Mail::mailer('default')->to($user->email)->send($mailable);
                Log::info('Sending email sucess ');
            }
        }
    }
}
