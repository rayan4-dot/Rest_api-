<?php

namespace App\Interfaces;

interface VideoRepositoryInterface
{
    public function all($courseId = null); 
    public function store(array $data);
    public function show($id);
    public function showForCourse($videoId, $courseId);
    public function update(array $data, $id);
    public function destroy($id);
}