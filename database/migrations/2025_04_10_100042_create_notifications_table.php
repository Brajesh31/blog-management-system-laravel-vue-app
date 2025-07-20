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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('related_post_id')->nullable();
            $table->unsignedBigInteger('related_comment_id')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();

            $table->enum('type', [
                'like',
                'comment',
                'reply',
                'follow',
                'mention',
                'bookmark',
                'tag',
                'share',
            ]);
            $table->boolean('is_read')->default(false);
            $table->text('message');
            $table->timestamp('read_at')->nullable();

            $table->foreign('related_post_id')->references('id')->on('posts')->nullOnDelete();
            $table->foreign('related_comment_id')->references('id')->on('comments')->nullOnDelete();
            $table->foreign('sender_id')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
