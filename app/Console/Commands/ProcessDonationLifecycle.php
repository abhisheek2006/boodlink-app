<?php

namespace App\Console\Commands;

use App\Services\DonationService;
use Illuminate\Console\Command;

class ProcessDonationLifecycle extends Command
{
    protected $signature = 'donations:process-lifecycle';

    protected $description = 'Releases donors whose cooldown has finished and reminds donors whose session timer has expired.';

    public function handle(DonationService $donationService): int
    {
        $released = $donationService->releaseFinishedCooldowns();
        $expired = $donationService->flagExpiredSessions();

        $this->info("Released {$released} donor(s) from cooldown.");
        $this->info("Flagged {$expired} expired session(s) for reminder.");

        return self::SUCCESS;
    }
}
