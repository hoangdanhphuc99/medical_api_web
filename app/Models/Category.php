<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Filterable;
    protected $table = 'categories';
    protected $fillable = [
        'title',
        'description',
        'image_url',

    ];

    protected $filterable = [
        'title',
        'description',

    ];


    protected $searchable = [
        'title',
        'description',

    ];
}
