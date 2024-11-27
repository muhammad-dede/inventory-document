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
        Schema::create('retrieval_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('retrieval_id')->index();
            $table->string('product_code')->nullable()->index();
            $table->double('qty')->default(0)->nullable();
            $table->string('section_code')->nullable()->index();
            $table->date('in_date')->nullable();
            $table->string('no_primary')->nullable();
            $table->unsignedBigInteger('pic_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('retrieval_id')->references('id')->on('retrieval')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_code')->references('code')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('section_code')->references('code')->on('section')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pic_id')->references('id')->on('pic')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retrieval_item');
    }
};
