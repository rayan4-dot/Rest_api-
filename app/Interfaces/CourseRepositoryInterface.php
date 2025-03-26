<?php

namespace App\Interfaces;

interface CourseRepositoryInterface
{
    public function getAll($relations = [], $search = null, $categoryId = null);
    public function findById($id, $relations = []);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}