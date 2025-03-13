<?php


namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories() 
    {
        return $this->categoryRepository->getAllCategories()->load('subcategories');
    }


    public function getCategoryById($id)
    {
        return $this->categoryRepository->getCategoryById($id);
    }


    public function createCategory(array $data)
    {
        return $this->categoryRepository->createCategory($data);
    }


    public function updateCategory($id, array $data)
    {
        return $this->categoryRepository->updateCategory($id, $data);
    }


    public function deleteCategory($id)
    {
        return $this->categoryRepository->deleteCategory($id);
    }


    public function getSubcategories($categoryId)
    {
        return $this->categoryRepository->getSubcategories($categoryId);
    }
}
