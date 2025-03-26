<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['title', 'description', 'status', 'mentor_id', 'category_id', 'sub_category_id']; 
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

        public function tags()
        {
            return $this->belongsToMany(Tag::class,'course_tags');
        }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function isEnrolledByStudent($studentId)
    {
        return $this->students()->where('student_id', $studentId)->exists();
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')
                    ->withPivot('progress_status') 
                    ->withTimestamps(); 
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
