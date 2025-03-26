<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function all();
    public function store(array $data);
    public function show($id);
    public function update($id, array $data);
    public function delete($id);
}

