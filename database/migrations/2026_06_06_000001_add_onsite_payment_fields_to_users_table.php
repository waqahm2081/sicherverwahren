<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'payment_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('payment_token')->nullable()->unique()->after('is_approved');
            });
        }

        if (! Schema::hasColumn('users', 'payment_completed')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('payment_completed')->default(false)->after('payment_token');
            });
        }
    }

    public function down(): void
    {
        $cols = array_values(array_filter(
            ['payment_completed', 'payment_token'],
            fn ($col) => Schema::hasColumn('users', $col)
        ));

        if ($cols) {
            Schema::table('users', function (Blueprint $table) use ($cols) {
                $table->dropColumn($cols);
            });
        }
    }
};
