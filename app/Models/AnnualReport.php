<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnualReport extends Model
{
    protected $fillable = [
        'title',
        'description',
        'year',
        'image_path',
        'pdf_path'
    ];
}