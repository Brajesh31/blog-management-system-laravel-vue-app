<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'read_at',
        'related_post_id',
        'related_comment_id',
        'sender_id'
    ];


    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function relatedPost() {
        return $this->belongsTo(Post::class, 'related_post_id');
    }

    public function relatedComment() {
        return $this->belongsTo(Comment::class, 'related_comment_id');
    }

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
