<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,completed',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'price' => 'nullable|numeric|min:0',
            
        ];


        //store case


        if ($this->isMethod('post')) {
            $rules['title'] = 'required|string|max:255';
            $rules['description'] = 'required|string';
            $rules['status'] = 'required|in:open,in_progress,completed';
            $rules['category_id'] = 'required|exists:categories,id';
        }
    }
}
