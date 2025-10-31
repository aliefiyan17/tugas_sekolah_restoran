<?php
// database/migrations/xxxx_xx_xx_add_reserved_fields_to_meja_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->dateTime('reserved_at')->nullable()->after('status');
            $table->string('reserved_by')->nullable()->after('reserved_at');
            $table->string('reserved_phone')->nullable()->after('reserved_by');
            $table->text('reserved_note')->nullable()->after('reserved_phone');
        });
    }

    public function down(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->dropColumn(['reserved_at', 'reserved_by', 'reserved_phone', 'reserved_note']);
        });
    }
};