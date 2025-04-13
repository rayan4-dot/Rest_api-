<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // No auth required
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'price' => 'nullable|numeric|min:0',
            'mentor_id' => 'nullable|exists:users,id',
        ];
    }
}