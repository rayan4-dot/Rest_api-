<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'course_id',  'progress_status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
