<?php

namespace App\Repositories;

use App\Models\Subcategory;
use App\Interfaces\SubcategoryRepositoryInterface;

class SubcategoryRepository implements SubcategoryRepositoryInterface
{
    public function all()
    {
        return Subcategory::with('category')->get();
    }

    public function create(array $data)
    {
        return Subcategory::create($data);
    }

    public function update($id, array $data)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->update($data);
        return $subcategory;
    }

    public function delete($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        return $subcategory->delete();
    }
}
