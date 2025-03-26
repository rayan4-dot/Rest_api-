<?php
namespace App\Repositories;
use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function all() { return Category::all(); }

    public function store(array $data) { return Category::create($data); }

    public function show($id) { return Category::findOrFail($id); }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        return $category->delete();
    }
}
