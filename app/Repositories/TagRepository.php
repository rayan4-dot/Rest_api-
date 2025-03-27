<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Interfaces\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    public function all()
    {
        return Tag::all();
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update($id, array $data)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($data);
        return $tag;
    }

    public function show($id) { return Tag::findOrFail($id); }


    public function delete($id)
    {
        $tag = Tag::findOrFail($id);
        return $tag->delete();
    }
}
