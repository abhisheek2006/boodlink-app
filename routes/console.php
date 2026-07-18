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
