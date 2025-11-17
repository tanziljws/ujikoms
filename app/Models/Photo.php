<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'description'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
{
    return $this->hasMany(Like::class, 'photo_id', 'id');
}

   // AKSESOR TOTAL LIKE (user + guest)
    public function getTotalLikesAttribute()
    {
        return $this->likes()->count() + ($this->guest_likes ?? 0);
    }

    public static function populerCount()
{
    return self::withCount('likes')
        ->having('likes_count', '>=', 5)
        ->get()
        ->count();
}

}
