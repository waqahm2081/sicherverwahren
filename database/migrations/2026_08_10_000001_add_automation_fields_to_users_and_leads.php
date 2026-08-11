<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->after('is_approved');
            $table->timestamp('access_ends_at')->nullable()->after('approved_at');
            $table->timestamp('shipped_at')->nullable()->after('payment_completed');
            $table->date('shipping_date')->nullable()->after('shipped_at');
            $table->string('tracking_number')->nullable()->after('shipping_date');
            $table->string('appointment_date')->nullable()->after('tracking_number');
            $table->string('appointment_location')->nullable()->after('appointment_date');
            $table->string('contact_person')->nullable()->after('appointment_location');
            $table->unsignedInteger('quoted_amount_chf')->nullable()->after('contact_person');
            $table->string('applied_coupon_code')->nullable()->after('quoted_amount_chf');
            $table->timestamp('reminder_10d_sent_at')->nullable()->after('applied_coupon_code');
            $table->timestamp('expired_email_sent_at')->nullable()->after('reminder_10d_sent_at');
            $table->timestamp('upsell_secure5_sent_at')->nullable()->after('expired_email_sent_at');
            $table->timestamp('upsell_pro7_sent_at')->nullable()->after('upsell_secure5_sent_at');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->timestamp('followup_sent_at')->nullable()->after('source');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'approved_at',
                'access_ends_at',
                'shipped_at',
                'shipping_date',
                'tracking_number',
                'appointment_date',
                'appointment_location',
                'contact_person',
                'quoted_amount_chf',
                'applied_coupon_code',
                'reminder_10d_sent_at',
                'expired_email_sent_at',
                'upsell_secure5_sent_at',
                'upsell_pro7_sent_at',
            ]);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('followup_sent_at');
        });
    }
};
