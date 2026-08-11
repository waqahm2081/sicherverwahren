<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('email');
            });
        }

        if (! Schema::hasColumn('users', 'selected_package')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('selected_package')->nullable()->after('phone');
            });
        }

        if (! Schema::hasColumn('users', 'selected_option_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('selected_option_type')->nullable()->after('selected_package');
            });
        }
    }

    public function down(): void
    {
        $cols = array_values(array_filter(
            ['selected_option_type', 'selected_package', 'phone'],
            fn ($col) => Schema::hasColumn('users', $col)
        ));

        if ($cols) {
            Schema::table('users', function (Blueprint $table) use ($cols) {
                $table->dropColumn($cols);
            });
        }
    }
};
