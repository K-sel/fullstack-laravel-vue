<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sub_title',
        'author',
        'reading_status',
        'resume',
        'format',
        'number_of_pages',
        'release_date',
        'editor',
        'isbn',
        'cover_image',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Relation 1(:N)
    }
}
