<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PurgeDeletedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:purge-deleted {--dry-run : Show which users would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete users whose 30-day grace period has expired (GDPR compliance)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        // Find soft-deleted users whose grace period has expired
        $users = User::onlyTrashed()
            ->whereNotNull('gdpr_deletion_requested_at')
            ->where('gdpr_deletion_requested_at', '<=', now()->subDays(30))
            ->get();

        if ($users->isEmpty()) {
            $this->info('No users to purge.');
            return Command::SUCCESS;
        }

        $this->info(sprintf('Found %d user(s) with expired grace period.', $users->count()));

        if ($dryRun) {
            $this->warn('DRY RUN - No users will be deleted.');
            $this->table(
                ['ID', 'Email', 'Deletion Requested', 'Days Expired'],
                $users->map(fn ($user) => [
                    $user->id,
                    $user->email,
                    $user->gdpr_deletion_requested_at->toDateString(),
                    now()->diffInDays($user->gdpr_deletion_requested_at) - 30,
                ])
            );
            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            // Permanently delete the user
            $user->forceDelete();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info(sprintf('Successfully purged %d user(s).', $users->count()));

        return Command::SUCCESS;
    }
}
