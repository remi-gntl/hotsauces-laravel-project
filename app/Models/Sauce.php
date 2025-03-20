<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sauce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'manufacturer',
        'description',
        'main_pepper',
        'image_url',
        'heat',
    ];

    protected $casts = [
        'users_liked' => 'array',
        'users_disliked' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}