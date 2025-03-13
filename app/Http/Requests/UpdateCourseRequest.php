<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
            'difficulty_level' => 'nullable|in:beginner,intermediate,advanced',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:open,in_progress,completed',
        ];
    }
}
