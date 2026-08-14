<?php

namespace App\Console\Commands;

use App\Services\AutomatedEmailService;
use Illuminate\Console\Command;

class ProcessAutomatedEmails extends Command
{
    protected $signature = 'sbv:process-automated-emails';

    protected $description = 'Send self-test follow-ups, course reminders, expiry and upsell emails';

    public function handle(AutomatedEmailService $emails): int
    {
        foreach ($emails->processScheduled() as $line) {
            $this->line($line);
        }

        $this->info('Automated emails processed.');

        return self::SUCCESS;
    }
}
