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
        Schema::create('retrieval', function (Blueprint $table) {
            $table->id();
            $table->date('retrieval_date')->nullable();
            $table->string('section_code')->nullable()->index();
            $table->unsignedBigInteger('pic_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('section_code')->references('code')->on('section')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('pic_id')->references('id')->on('pic')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retrieval');
    }
};
