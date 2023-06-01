<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'title',
        'short_title',
        'short_description',
        'long_description',
        'about_image'
    ];
    use HasFactory;
}
