<?php

namespace App\Models\lanonnarose;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product_lanonnarose';

        protected $fillable = [
            'section_es',
            'section_en',
            'title_es',
            'title_en',
            'name',
            'shortDescription_es',
            'shortDescription_en',
            'description_es',
            'description_en',
            'imageUrl',
            'isImportant'
        ];
}