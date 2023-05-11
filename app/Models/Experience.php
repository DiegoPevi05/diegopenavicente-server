<?php

namespace App\Models;

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
            'image1',
            'image2',
            'image3',
            'image4'
        ];
}
