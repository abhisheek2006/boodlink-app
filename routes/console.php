<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
| Runs every 5 minutes: flips Waiting donors back to Available once their
| cooldown ends, and reminds donors whose 30-minute session timer expired.
*/
Schedule::command('donations:process-lifecycle')->everyFiveMinutes();

/*
|--------------------------------------------------------------------------
| Daily Birthday Emails
|--------------------------------------------------------------------------
| At 09:00 each day, sends a birthday wish email to every user whose
| date-of-birth falls on that calendar day.
*/
Schedule::command('birthdays:send')->dailyAt('09:00');
