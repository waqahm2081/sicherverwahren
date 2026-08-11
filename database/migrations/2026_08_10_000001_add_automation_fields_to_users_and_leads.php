<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'approved_at'            => fn (Blueprint $t) => $t->timestamp('approved_at')->nullable()->after('is_approved'),
            'access_ends_at'         => fn (Blueprint $t) => $t->timestamp('access_ends_at')->nullable()->after('approved_at'),
            'shipped_at'             => fn (Blueprint $t) => $t->timestamp('shipped_at')->nullable()->after('payment_completed'),
            'shipping_date'          => fn (Blueprint $t) => $t->date('shipping_date')->nullable()->after('shipped_at'),
            'tracking_number'        => fn (Blueprint $t) => $t->string('tracking_number')->nullable()->after('shipping_date'),
            'appointment_date'       => fn (Blueprint $t) => $t->string('appointment_date')->nullable()->after('tracking_number'),
            'appointment_location'   => fn (Blueprint $t) => $t->string('appointment_location')->nullable()->after('appointment_date'),
            'contact_person'         => fn (Blueprint $t) => $t->string('contact_person')->nullable()->after('appointment_location'),
            'quoted_amount_chf'      => fn (Blueprint $t) => $t->unsignedInteger('quoted_amount_chf')->nullable()->after('contact_person'),
            'applied_coupon_code'    => fn (Blueprint $t) => $t->string('applied_coupon_code')->nullable()->after('quoted_amount_chf'),
            'reminder_10d_sent_at'   => fn (Blueprint $t) => $t->timestamp('reminder_10d_sent_at')->nullable()->after('applied_coupon_code'),
            'expired_email_sent_at'  => fn (Blueprint $t) => $t->timestamp('expired_email_sent_at')->nullable()->after('reminder_10d_sent_at'),
            'upsell_secure5_sent_at' => fn (Blueprint $t) => $t->timestamp('upsell_secure5_sent_at')->nullable()->after('expired_email_sent_at'),
            'upsell_pro7_sent_at'    => fn (Blueprint $t) => $t->timestamp('upsell_pro7_sent_at')->nullable()->after('upsell_secure5_sent_at'),
        ];

        foreach ($columns as $name => $definition) {
            if (! Schema::hasColumn('users', $name)) {
                Schema::table('users', function (Blueprint $table) use ($definition) {
                    $definition($table);
                });
            }
        }

        if (Schema::hasTable('leads') && ! Schema::hasColumn('leads', 'followup_sent_at')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->timestamp('followup_sent_at')->nullable()->after('source');
            });
        }
    }

    public function down(): void
    {
        $cols = array_values(array_filter([
            'upsell_pro7_sent_at',
            'upsell_secure5_sent_at',
            'expired_email_sent_at',
            'reminder_10d_sent_at',
            'applied_coupon_code',
            'quoted_amount_chf',
            'contact_person',
            'appointment_location',
            'appointment_date',
            'tracking_number',
            'shipping_date',
            'shipped_at',
            'access_ends_at',
            'approved_at',
        ], fn ($col) => Schema::hasColumn('users', $col)));

        if ($cols) {
            Schema::table('users', function (Blueprint $table) use ($cols) {
                $table->dropColumn($cols);
            });
        }

        if (Schema::hasTable('leads') && Schema::hasColumn('leads', 'followup_sent_at')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->dropColumn('followup_sent_at');
            });
        }
    }
};
