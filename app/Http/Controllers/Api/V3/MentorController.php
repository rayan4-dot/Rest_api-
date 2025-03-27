<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('search');

        $mentors = User::select('id', 'name') 
            ->whereHas('roles', function ($q) {
                $q->where('name', 'mentor');
            })
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhereHas('createdCourses', function ($q) use ($query) {
                      $q->where('title', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                  });
            })
            ->with(['createdCourses' => function ($q) {
                $q->select('id', 'title', 'description', 'mentor_id');
            }])
            ->get(); 

        return response()->json($mentors);
    }
}
