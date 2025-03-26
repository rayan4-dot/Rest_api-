<?php

namespace App\Services;

use App\Interfaces\SubcategoryRepositoryInterface;

class SubcategoryService
{
    protected $subcategoryRepository;

    public function __construct(SubcategoryRepositoryInterface $subcategoryRepository)
    {
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function all()
    {
        return $this->subcategoryRepository->all();
    }

    public function create(array $data)
    {
        return $this->subcategoryRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->subcategoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->subcategoryRepository->delete($id);
    }
}
