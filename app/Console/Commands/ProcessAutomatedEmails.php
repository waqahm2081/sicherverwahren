<?php

namespace App\Console\Commands;

use App\Mail\CourseExpiredMail;
use App\Mail\CourseExpiryReminderMail;
use App\Mail\LeadFollowupMail;
use App\Mail\UpsellPro7Mail;
use App\Mail\UpsellSecure5Mail;
use App\Models\Coupon;
use App\Models\Lead;
use App\Models\User;
use App\Services\CouponService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessAutomatedEmails extends Command
{
    protected $signature = 'sbv:process-automated-emails';

    protected $description = 'Send self-test follow-ups, course reminders, expiry and upsell emails';

    public function handle(CouponService $coupons): int
    {
        $this->sendLeadFollowups();
        $this->sendCourseReminders();
        $this->sendCourseExpired();
        $this->sendUpsells($coupons);

        $this->info('Automated emails processed.');

        return self::SUCCESS;
    }

    protected function sendLeadFollowups(): void
    {
        $leads = Lead::query()
            ->whereNull('followup_sent_at')
            ->where('created_at', '<=', now()->subDays(2))
            ->get();

        foreach ($leads as $lead) {
            Mail::to($lead->email)->send(new LeadFollowupMail($lead->name));
            $lead->update(['followup_sent_at' => now()]);
            $this->line("Lead follow-up → {$lead->email}");
        }
    }

    protected function sendCourseReminders(): void
    {
        $users = User::query()
            ->where('role', 'user')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->whereNull('reminder_10d_sent_at')
            ->whereDate('access_ends_at', now()->addDays(10)->toDateString())
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new CourseExpiryReminderMail($user));
            $user->update(['reminder_10d_sent_at' => now()]);
            $this->line("10-day reminder → {$user->email}");
        }
    }

    protected function sendCourseExpired(): void
    {
        $users = User::query()
            ->where('role', 'user')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->where('access_ends_at', '<=', now())
            ->whereNull('expired_email_sent_at')
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new CourseExpiredMail($user));
            $user->update(['expired_email_sent_at' => now()]);
            $this->line("Expired email → {$user->email}");
        }
    }

    protected function sendUpsells(CouponService $coupons): void
    {
        // Private Starter → Private Secure, 30 days after access ended
        $starterUsers = User::query()
            ->where('role', 'user')
            ->where('selected_package', 'Private Starter')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->where('access_ends_at', '<=', now()->subDays(30))
            ->whereNull('upsell_secure5_sent_at')
            ->get();

        $secureCoupon = Coupon::findByCode('SECURE5');

        foreach ($starterUsers as $user) {
            if ($this->emailOwnsPackage($user->email, 'Private Secure')) {
                $user->update(['upsell_secure5_sent_at' => now()]); // mark so we don't retry forever
                continue;
            }

            if ($secureCoupon) {
                $coupons->grantUpsellCoupon($secureCoupon, $user, 7);
            }

            Mail::to($user->email)->send(new UpsellSecure5Mail($user));
            $user->update(['upsell_secure5_sent_at' => now()]);
            $this->line("SECURE5 upsell → {$user->email}");
        }

        // Business Essential → Business Professional
        $essentialUsers = User::query()
            ->where('role', 'user')
            ->where('selected_package', 'Business Essential')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->where('access_ends_at', '<=', now()->subDays(30))
            ->whereNull('upsell_pro7_sent_at')
            ->get();

        $proCoupon = Coupon::findByCode('PRO7');

        foreach ($essentialUsers as $user) {
            if ($this->emailOwnsPackage($user->email, 'Business Professional')) {
                $user->update(['upsell_pro7_sent_at' => now()]);
                continue;
            }

            if ($proCoupon) {
                $coupons->grantUpsellCoupon($proCoupon, $user, 7);
            }

            Mail::to($user->email)->send(new UpsellPro7Mail($user));
            $user->update(['upsell_pro7_sent_at' => now()]);
            $this->line("PRO7 upsell → {$user->email}");
        }
    }

    protected function emailOwnsPackage(string $email, string $package): bool
    {
        return User::where('email', $email)
            ->where('selected_package', $package)
            ->where('payment_completed', true)
            ->exists();
    }
}
