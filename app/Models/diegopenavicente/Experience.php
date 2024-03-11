<?php

namespace App\Models\diegopenavicente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = 'experiences';

        protected $fillable = [
            'job_es',
            'job_en',
            'job_it',
            'company',
            'details_es',
            'details_en',
            'details_it',
            'startDate',
            'endDate',
            'is_active',
            'image1',
            'image2',
            'image3',
            'image4'
        ];
}
