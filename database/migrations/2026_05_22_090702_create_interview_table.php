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
        Schema::create('entretiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidature_id')->constrained()->onDelete('cascade');
            $table->string('type', 100);
            $table->dateTime('scheduled_at');
            $table->text('preparation_notes')->nullable();
            $table->string('result', 100)->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview');
    }
};
