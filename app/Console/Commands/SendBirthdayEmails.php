<?php

namespace App\Console\Commands;

use App\Mail\BirthdayWish;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmails extends Command
{
    protected $signature = 'birthdays:send';
    protected $description = 'Send birthday wish emails to all users celebrating a birthday today.';

    public function handle(): int
    {
        // Find every active user whose birthday is today.
        $users = User::whereNotNull('email')
            ->where('status', 'Active')
            ->whereMonth('dob', now()->month)
            ->whereDay('dob', now()->day)
            ->get();

        if ($users->isEmpty()) {
            $this->info('No birthdays today.');
            return self::SUCCESS;
        }

        $sent = 0;
        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new BirthdayWish($user));
                $sent++;
            } catch (\Throwable $e) {
                $this->warn("Failed to send to {$user->email}: " . $e->getMessage());
            }
        }

        $this->info("Sent {$sent} birthday email(s) to users celebrating today.");

        return self::SUCCESS;
    }
}
