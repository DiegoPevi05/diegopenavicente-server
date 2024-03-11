<?php

namespace App\Models\diegopenavicente;

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
        'github'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skill')->withTimestamps();
    }
}
