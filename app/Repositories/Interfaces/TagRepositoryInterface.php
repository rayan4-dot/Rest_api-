<?php


namespace App\Repositories\Interfaces;

interface TagRepositoryInterface
{
    public function getAllTags();
    public function getTagById($id);
    public function createTag(array $data);
    public function updateTag($id, array $data);
    public function deleteTag($id);
}
