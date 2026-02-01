<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'date',
        'content',
        'link',
        'image',
        'page_category_id',
        'status',
        'serial',
        'name',
        'phone',
        'email',
        'designation'
    ];

    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'page_category_id' => 'integer',
        'date' => 'date',
    ];

    public function pageCategory()
    {
        return $this->belongsTo(Pagecategory::class, 'page_category_id');
    }
}
