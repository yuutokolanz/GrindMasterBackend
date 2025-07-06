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
        Schema::create('cs_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('map_played');
            $table->integer('kills');
            $table->integer('deaths');
            $table->float('hs_percent', 5, 2);
            $table->integer('mvps');
            $table->foreignId('contest_id')->unique()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cs_stats');
    }
};
