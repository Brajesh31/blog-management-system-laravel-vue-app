<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon; // Import Carbon for date manipulation
use Illuminate\Support\Facades\Storage; // If handling default pic logic here
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['formatted_join_date']; // Add our accessors here

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


   /**
     * Get the user's formatted join date.
     * Uses PHP 8 attribute syntax.
     */

    protected function formattedJoinDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => isset($attributes['created_at'])
                ? Carbon::parse($attributes['created_at'])->format('M j, Y') // Format: e.g., Aug 15, 2023
                : null,
        );
    }


    //Relationships
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }

}
