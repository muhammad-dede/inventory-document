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
        Schema::create('pic', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('section_code')->nullable()->index();
            $table->timestamps();

            $table->foreign('section_code')->references('code')->on('section')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pic');
    }
};
