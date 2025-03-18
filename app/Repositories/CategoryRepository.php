<?php
namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::with('subcategories')->get();
    }

    public function getCategoryById($id)
    {
        return Category::with('subcategories')->findOrFail($id);
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        return $category->delete();
    }

    public function getSubcategories($categoryId)
    {
        return Category::where('parent_id', $categoryId)->get();
    }
}
