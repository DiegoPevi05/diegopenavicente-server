<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

        protected $fillable = [
            'project',
            'logo',
            'description_es',
            'description_en',
            'description_it',
            'link',
            'languages'
        ];
}
