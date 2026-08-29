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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete(); // মেম্বারের আইডি
            $table->date('collection_date'); // জমার তারিখ
            $table->decimal('amount', 8, 2)->default(100.00); // চাঁদার পরিমাণ (ডিফল্ট ১০০ টাকা)
            $table->boolean('is_paid')->default(0); // 0 = Due, 1 = Paid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
