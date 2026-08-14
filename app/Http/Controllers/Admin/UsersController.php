<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\HardwareShippedMail;
use App\Mail\OnsitePaymentLink;
use App\Mail\UserApproved;
use App\Models\PricingPackage;
use App\Models\PricingPackageOption;
use App\Models\User;
use App\Services\AutomatedEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name',  'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%");
            });
        }

        if ($request->filled('package')) {
            $query->where('selected_package', $request->package);
        }

        if ($request->filled('type') && in_array($request->type, ['digital', 'onsite'])) {
            $query->where('selected_option_type', $request->type);
        }

        if ($request->filled('order_status')) {
            if ($request->order_status === 'ordered') {
                $query->whereNotNull('selected_package');
            } else {
                $query->whereNull('selected_package');
            }
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'   => User::where('role', 'user')->count(),
            'ordered' => User::where('role', 'user')->whereNotNull('selected_package')->count(),
            'digital' => User::where('role', 'user')->where('selected_option_type', 'digital')->count(),
            'onsite'  => User::where('role', 'user')->where('selected_option_type', 'onsite')->count(),
        ];

        $packages = PricingPackage::orderBy('sort_order')->pluck('name');

        return view('admin.users.index', compact('users', 'stats', 'packages'));
    }

    public function approve(User $user)
    {
        abort_if($user->role === 'admin', 403);

        if ($user->selected_option_type === 'onsite') {
            return redirect()
                ->route('admin.orders.show', $user)
                ->with('info', 'Bitte Termin und Betrag hinterlegen und den Zahlungslink von der Bestellseite senden.');
        }

        // Digital: activate 60-day access from approval
        $user->activateCourseAccess();
        Mail::to($user->email)->send(new UserApproved($user->fresh()));

        return back()->with('success', 'Benutzer „' . $user->name . '" wurde freigeschaltet.');
    }

    public function sendPaymentLink(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);
        abort_unless($user->selected_option_type === 'onsite', 422);

        $option = PricingPackageOption::whereHas('package', fn ($q) => $q->where('name', $user->selected_package))
            ->where('type', 'onsite')
            ->first();

        $validated = $request->validate([
            'quoted_amount_chf'    => ['required', 'integer', 'min:1'],
            'appointment_date'     => ['required', 'string', 'max:255'],
            'appointment_location' => ['required', 'string', 'max:255'],
            'contact_person'       => ['nullable', 'string', 'max:255'],
        ]);

        // Prefer submitted amount; fall back to catalogue price if somehow empty
        if (empty($validated['quoted_amount_chf']) && $option) {
            $validated['quoted_amount_chf'] = (int) $option->price_chf;
        }

        $token = Str::random(48);

        $user->update([
            'payment_token'        => $token,
            'quoted_amount_chf'    => $validated['quoted_amount_chf'],
            'appointment_date'     => $validated['appointment_date'],
            'appointment_location' => $validated['appointment_location'],
            'contact_person'       => $validated['contact_person'] ?? 'Sicher Bitcoin Verwahren',
        ]);

        Mail::to($user->email)->send(new OnsitePaymentLink($user->fresh()));

        return back()->with('success', 'Zahlungslink an „' . $user->name . '" gesendet.');
    }

    public function markShipped(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);
        abort_unless($user->selected_option_type === 'digital', 422);

        $validated = $request->validate([
            'shipping_date'   => ['required', 'date'],
            'tracking_number' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'shipped_at'      => now(),
            'shipping_date'   => $validated['shipping_date'],
            'tracking_number' => $validated['tracking_number'] ?: null,
        ]);

        Mail::to($user->email)->send(new HardwareShippedMail($user->fresh()));

        return back()->with('success', 'Versandbestätigung an „' . $user->name . '" gesendet.');
    }

    public function updateAccess(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);
        abort_unless($user->selected_option_type === 'digital', 422);

        $validated = $request->validate([
            'approved_at'    => ['nullable', 'date'],
            'access_ends_at' => ['nullable', 'date'],
            'reset_flags'    => ['nullable', 'array'],
            'reset_flags.*'  => ['in:reminder_10d_sent_at,expired_email_sent_at,upsell_secure5_sent_at,upsell_pro7_sent_at'],
        ]);

        $data = [
            'approved_at'    => $validated['approved_at'] ?? null,
            'access_ends_at' => $validated['access_ends_at'] ?? null,
        ];

        foreach ($validated['reset_flags'] ?? [] as $flag) {
            $data[$flag] = null;
        }

        $user->update($data);

        return back()->with('success', 'Videozugang für „' . $user->name . '" wurde aktualisiert.');
    }

    public function simulateAccess(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);
        abort_unless($user->selected_option_type === 'digital', 422);

        $validated = $request->validate([
            'preset' => ['required', 'in:reminder_10d,expired,upsell_due'],
        ]);

        $data = match ($validated['preset']) {
            'reminder_10d' => [
                'access_ends_at'       => now()->addDays(10)->endOfDay(),
                'reminder_10d_sent_at' => null,
            ],
            'expired' => [
                'access_ends_at'        => now()->subDay()->endOfDay(),
                'expired_email_sent_at' => null,
            ],
            'upsell_due' => [
                'access_ends_at'         => now()->subDays(31)->endOfDay(),
                'upsell_secure5_sent_at' => null,
                'upsell_pro7_sent_at'    => null,
            ],
        };

        $user->update($data);

        $labels = [
            'reminder_10d' => '10 Tage verbleibend',
            'expired'      => 'Zugang abgelaufen',
            'upsell_due'   => 'Upsell fällig',
        ];

        return back()->with('success', 'Simulation „' . $labels[$validated['preset']] . '" für „' . $user->name . '" gesetzt.');
    }

    public function sendAutomatedEmail(Request $request, User $user, AutomatedEmailService $emails)
    {
        abort_if($user->role === 'admin', 403);
        abort_unless($user->selected_option_type === 'digital', 422);

        $validated = $request->validate([
            'type' => ['required', 'in:reminder,expired,upsell_secure5,upsell_pro7'],
        ]);

        try {
            $result = match ($validated['type']) {
                'reminder'        => $emails->sendReminder($user, true),
                'expired'         => $emails->sendExpired($user, true),
                'upsell_secure5'  => $emails->sendUpsellSecure5($user, true),
                'upsell_pro7'     => $emails->sendUpsellPro7($user, true),
            };
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', $result !== ''
            ? 'E-Mail gesendet: ' . $result
            : 'E-Mail wurde nicht gesendet.');
    }

    public function edit(User $user)
    {
        abort_if($user->role === 'admin', 403);
        $packages = PricingPackage::with('options')->orderBy('sort_order')->get();
        return view('admin.users.edit', compact('user', 'packages'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);

        $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'                => ['nullable', 'string', 'max:50'],
            'selected_package'     => ['nullable', 'string', 'max:255'],
            'selected_option_type' => ['nullable', 'in:digital,onsite'],
            'password'             => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name'                 => $request->name,
            'email'                => $request->email,
            'phone'                => $request->phone,
            'selected_package'     => $request->selected_package ?: null,
            'selected_option_type' => $request->selected_option_type ?: null,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Benutzer „' . $user->name . '" wurde erfolgreich aktualisiert.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role === 'admin', 403);
        $name = $user->name;
        $user->delete();

        return back()->with('success', 'Benutzer „' . $name . '" wurde gelöscht.');
    }
}
