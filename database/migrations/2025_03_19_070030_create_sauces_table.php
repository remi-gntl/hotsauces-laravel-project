<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sauces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('manufacturer');
            $table->text('description');
            $table->string('main_pepper');
            $table->string('image_url')->nullable();
            $table->integer('heat')->default(1);
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->json('users_liked')->default('[]');
            $table->json('users_disliked')->default('[]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sauces');
    }
};
