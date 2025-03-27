<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\TagService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        return response()->json($this->tagService->all());
    }

    public function store(StoreTagRequest $request)
    {
        return response()->json($this->tagService->create($request->validated()), 201);
    }


    public function show($id)
    {
        return response()->json($this->tagService->show($id));
    }

    public function update(UpdateTagRequest $request, $id)
    {
        return response()->json($this->tagService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->tagService->delete($id);
        return response()->json(['message' => 'Tag deleted']);
    }
}
