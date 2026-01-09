<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'title',
        'hero_image',
        'description',
        'mission',
        'vision',
        'story',
        'meta_title',
        'meta_description',
        'is_active',
        'ceo_name',
        'ceo_position',
        'ceo_message',
        'ceo_image'
    ];
}
