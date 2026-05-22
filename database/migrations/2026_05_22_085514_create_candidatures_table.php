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
       Schema::create('candidatures', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('company', 255);
        $table->string('position', 255);
        $table->string('offer_url')->nullable();
        $table->enum('status', ['sent', 'interview', 'offer', 'rejected', 'withdrawn'])->default('sent');
        $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
        $table->text('notes')->nullable();
        $table->date('applied_at');
        $table->softDeletes(); // adds deleted_at column automatically
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
