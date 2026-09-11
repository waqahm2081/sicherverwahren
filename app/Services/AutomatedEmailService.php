<?php

namespace App\Services;

use App\Mail\CourseExpiredMail;
use App\Mail\CourseExpiryReminderMail;
use App\Mail\LeadFollowupMail;
use App\Mail\UpsellPro7Mail;
use App\Mail\UpsellSecure5Mail;
use App\Models\Coupon;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AutomatedEmailService
{
    public function __construct(protected CouponService $coupons) {}

    /**
     * @return list<string>
     */
    public function processScheduled(): array
    {
        return array_merge(
            $this->sendLeadFollowups(),
            $this->sendDueReminders(),
            $this->sendDueExpired(),
            $this->sendDueUpsells(),
        );
    }

    /**
     * @return list<string>
     */
    public function sendLeadFollowups(): array
    {
        $messages = [];

        $leads = Lead::query()
            ->whereNull('followup_sent_at')
            ->where('created_at', '<=', now()->subDays(2))
            ->orderBy('id')
            ->get();

        foreach ($leads as $lead) {
            if (! $this->isDeliverableEmail($lead->email)) {
                $lead->update(['followup_sent_at' => now()]);
                $messages[] = "Lead follow-up SKIPPED (invalid email) → {$lead->email}";
                continue;
            }

            try {
                Mail::to($lead->email)->send(new LeadFollowupMail($lead->name));
                $lead->update(['followup_sent_at' => now()]);
                $messages[] = "Lead follow-up → {$lead->email}";
            } catch (\Throwable $e) {
                report($e);
                $messages[] = "Lead follow-up FAILED → {$lead->email}: {$e->getMessage()}";
            }
        }

        return $messages;
    }

    /**
     * @return list<string>
     */
    public function sendDueReminders(): array
    {
        $messages = [];

        $users = User::query()
            ->where('role', 'user')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->whereNull('reminder_10d_sent_at')
            ->whereDate('access_ends_at', now()->addDays(10)->toDateString())
            ->get();

        foreach ($users as $user) {
            try {
                $messages[] = $this->sendReminder($user);
            } catch (\Throwable $e) {
                report($e);
                $messages[] = "10-day reminder FAILED → {$user->email}: {$e->getMessage()}";
            }
        }

        return array_values(array_filter($messages));
    }

    /**
     * @return list<string>
     */
    public function sendDueExpired(): array
    {
        $messages = [];

        $users = User::query()
            ->where('role', 'user')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->where('access_ends_at', '<=', now())
            ->whereNull('expired_email_sent_at')
            ->get();

        foreach ($users as $user) {
            try {
                $messages[] = $this->sendExpired($user);
            } catch (\Throwable $e) {
                report($e);
                $messages[] = "Expired email FAILED → {$user->email}: {$e->getMessage()}";
            }
        }

        return array_values(array_filter($messages));
    }

    /**
     * @return list<string>
     */
    public function sendDueUpsells(): array
    {
        $messages = [];

        $starterUsers = User::query()
            ->where('role', 'user')
            ->where('selected_package', 'Private Starter')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->where('access_ends_at', '<=', now()->subDays(30))
            ->whereNull('upsell_secure5_sent_at')
            ->get();

        foreach ($starterUsers as $user) {
            try {
                $messages[] = $this->sendUpsellSecure5($user);
            } catch (\Throwable $e) {
                report($e);
                $messages[] = "SECURE5 FAILED → {$user->email}: {$e->getMessage()}";
            }
        }

        $essentialUsers = User::query()
            ->where('role', 'user')
            ->where('selected_package', 'Business Essential')
            ->where('selected_option_type', 'digital')
            ->whereNotNull('access_ends_at')
            ->where('access_ends_at', '<=', now()->subDays(30))
            ->whereNull('upsell_pro7_sent_at')
            ->get();

        foreach ($essentialUsers as $user) {
            try {
                $messages[] = $this->sendUpsellPro7($user);
            } catch (\Throwable $e) {
                report($e);
                $messages[] = "PRO7 FAILED → {$user->email}: {$e->getMessage()}";
            }
        }

        return array_values(array_filter($messages));
    }

    public function sendReminder(User $user, bool $force = false): string
    {
        $this->assertDigital($user);

        if (! $force) {
            if ($user->reminder_10d_sent_at) {
                return '';
            }
            if (! $user->access_ends_at || $user->access_ends_at->toDateString() !== now()->addDays(10)->toDateString()) {
                return '';
            }
        }

        Mail::to($user->email)->send(new CourseExpiryReminderMail($user->fresh()));
        $user->update(['reminder_10d_sent_at' => now()]);

        return "10-day reminder → {$user->email}";
    }

    public function sendExpired(User $user, bool $force = false): string
    {
        $this->assertDigital($user);

        if (! $force) {
            if ($user->expired_email_sent_at) {
                return '';
            }
            if (! $user->access_ends_at || $user->access_ends_at->isFuture()) {
                return '';
            }
        }

        Mail::to($user->email)->send(new CourseExpiredMail($user->fresh()));
        $user->update(['expired_email_sent_at' => now()]);

        return "Expired email → {$user->email}";
    }

    public function sendUpsellSecure5(User $user, bool $force = false): string
    {
        $this->assertDigital($user);

        if ($user->selected_package !== 'Private Starter') {
            throw new \InvalidArgumentException('SECURE5-Upsell gilt nur für Private Starter.');
        }

        if (! $force) {
            if ($user->upsell_secure5_sent_at) {
                return '';
            }
            if (! $user->access_ends_at || $user->access_ends_at->gt(now()->subDays(30))) {
                return '';
            }
        }

        if ($this->emailOwnsPackage($user->email, 'Private Secure')) {
            $user->update(['upsell_secure5_sent_at' => now()]);

            return "SECURE5 skipped (already owns Private Secure) → {$user->email}";
        }

        $coupon = Coupon::findByCode('SECURE5');
        if ($coupon) {
            $this->coupons->grantUpsellCoupon($coupon, $user, 7);
        }

        Mail::to($user->email)->send(new UpsellSecure5Mail($user->fresh()));
        $user->update(['upsell_secure5_sent_at' => now()]);

        return "SECURE5 upsell → {$user->email}";
    }

    public function sendUpsellPro7(User $user, bool $force = false): string
    {
        $this->assertDigital($user);

        if ($user->selected_package !== 'Business Essential') {
            throw new \InvalidArgumentException('PRO7-Upsell gilt nur für Business Essential.');
        }

        if (! $force) {
            if ($user->upsell_pro7_sent_at) {
                return '';
            }
            if (! $user->access_ends_at || $user->access_ends_at->gt(now()->subDays(30))) {
                return '';
            }
        }

        if ($this->emailOwnsPackage($user->email, 'Business Professional')) {
            $user->update(['upsell_pro7_sent_at' => now()]);

            return "PRO7 skipped (already owns Business Professional) → {$user->email}";
        }

        $coupon = Coupon::findByCode('PRO7');
        if ($coupon) {
            $this->coupons->grantUpsellCoupon($coupon, $user, 7);
        }

        Mail::to($user->email)->send(new UpsellPro7Mail($user->fresh()));
        $user->update(['upsell_pro7_sent_at' => now()]);

        return "PRO7 upsell → {$user->email}";
    }

    protected function assertDigital(User $user): void
    {
        if ($user->role === 'admin' || $user->selected_option_type !== 'digital') {
            throw new \InvalidArgumentException('Diese E-Mail gilt nur für digitale Kundenkonten.');
        }
    }

    protected function isDeliverableEmail(?string $email): bool
    {
        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = substr(strrchr($email, '@'), 1) ?: '';

        // Fake/test domains that Hostpoint rejects as unroutable
        $blocked = ['test', 'example.com', 'example.org', 'example.net', 'localhost', 'invalid'];

        return ! in_array(strtolower($domain), $blocked, true);
    }

    protected function emailOwnsPackage(string $email, string $package): bool
    {
        return User::where('email', $email)
            ->where('selected_package', $package)
            ->where('payment_completed', true)
            ->exists();
    }
}
