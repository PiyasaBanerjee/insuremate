<?php

namespace App\Console\Commands;

use App\Models\Policy;
use App\Notifications\UpcomingRenewalNotification;
use Illuminate\Console\Command;

class NotifyRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insuremate:notify-renewals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to users with upcoming policy renewals.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for upcoming renewals...');

        // Find active policies that are due for renewal in the next 30 days
        $policies = Policy::where('status', 'active')
            ->whereDate('next_renewal_date', '<=', now()->addDays(30))
            ->whereDate('next_renewal_date', '>=', now())
            ->get();

        $count = 0;
        foreach ($policies as $policy) {
            // In a real app, you'd check if they were already notified for this cycle
            // For now, we will just send it if they haven't been notified today.
            $alreadyNotifiedToday = $policy->user->notifications()
                ->where('type', UpcomingRenewalNotification::class)
                ->whereDate('created_at', today())
                ->exists();

            if (!$alreadyNotifiedToday) {
                $policy->user->notify(new UpcomingRenewalNotification($policy));
                $count++;
            }
        }

        $this->info("Successfully notified $count users about upcoming renewals.");
    }
}
