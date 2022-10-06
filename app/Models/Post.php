<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable=[
        'image_url',
        'name',
        'status',
        'description',
        'detail',
        "category_id"
    ];

    protected $filterable = [
        'category_id',

    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
