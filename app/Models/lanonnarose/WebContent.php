<?php

namespace App\Models\lanonnarose;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webcontent extends Model
{
    use HasFactory;

    protected $table = 'web_contents_lanonnarose';

        protected $fillable = [
            'name',
            'content_es',
            'content_en'
        ];
}