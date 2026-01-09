<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('commendes', function (Blueprint $table) {
            $table->string('lieu')->nullable()->after('etat');
            $table->text('description')->nullable()->after('lieu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commendes', function (Blueprint $table) {
            $table->dropColumn(['lieu', 'description']);
        });
    }
};
