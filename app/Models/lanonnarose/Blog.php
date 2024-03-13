<?php

namespace App\Models\lanonnarose;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog_lanonnarose';

        protected $fillable = [
            'title_es',
            'title_en',
            'subTitle_es',
            'subTitle_en',
            'description_es',
            'description_en',
            'image1',
            'image2',
            'image3',
            'image4',
            'bulletpoints_es',
            'bulletpoints_en',
            'isImportant'
        ];
}