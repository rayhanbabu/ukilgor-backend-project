<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagecategory extends Model
{
    use HasFactory;


     protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'page_category_id' => 'integer',
        'date' => 'date',
    ];


    public function parent()
   {
    return $this->belongsTo(Pagecategory::class, 'parent_id');
   }


    public function children()
{
    return $this->hasMany(Pagecategory::class, 'parent_id')->with('children');
}


  public function pages()
    {
        return $this->hasMany(Page::class, 'page_category_id');
    }
  
}
