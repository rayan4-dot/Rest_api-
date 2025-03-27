<?php

namespace App\Services;

use App\Interfaces\TagRepositoryInterface;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function all()
    {
        return $this->tagRepository->all();
    }

    public function create(array $data)
    {
        return $this->tagRepository->create($data);
    }
    public function show($id) { return $this->tagRepository->show($id); }


    public function update($id, array $data)
    {
        return $this->tagRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->tagRepository->delete($id);
    }
}
