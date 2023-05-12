<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebContent extends Model
{
    use HasFactory;

    protected $table = 'web_contents';

        protected $fillable = [
            'name',
            'content_es',
            'content_en',
            'content_it',
        ];
}
