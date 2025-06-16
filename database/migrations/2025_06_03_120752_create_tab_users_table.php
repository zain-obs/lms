<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tab_users', function (Blueprint $table) {
            $table->id();
            $table->integer('priority');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tab_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tab_users');
    }
};
