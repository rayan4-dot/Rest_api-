<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';
    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
