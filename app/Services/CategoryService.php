<?php

namespace App\Services;


use App\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all() { return $this->categoryRepository->all(); }

    public function store($data) { return $this->categoryRepository->store($data); }

    public function show($id) { return $this->categoryRepository->show($id); }

    public function update($id, $data) { return $this->categoryRepository->update($id, $data); }

    public function delete($id) { return $this->categoryRepository->delete($id); }
}
