<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

        protected $fillable = [
            'title',
            'type',
            'author',
            'content_es',
            'content_en',
            'content_it',
            'href',
            'img'
        ];
}
