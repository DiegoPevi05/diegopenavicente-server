<?php

namespace App\Models\diegopenavicente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';

    protected $fillable = [
        'title',
        'image',
        'description_es',
        'description_en',
        'description_it',
        'keywords'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skill')->withTimestamps();
    }
}

