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
        Schema::create('travelplans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->charset('utf8')->collation('utf8_unicode_ci');
            $table->text('description');
            $table->date('date');
            $table->string('location')->charset('utf8')->collation('utf8_unicode_ci');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travelplans');
    }
};
