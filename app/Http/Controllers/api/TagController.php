<?php

namespace App\Http\Controllers\Api;

use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
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
        $tags = $this->tagService->getAllTags();
        return response()->json([
            'tags' => TagResource::collection($tags),
        ]);
    }

    public function show($id)
    {
        $tag = $this->tagService->getTagById($id);
        return new TagResource($tag);
    }

    public function store(StoreTagRequest $request)
    {

        if (!Gate::allows('manage-tags')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validated();
        $tag = $this->tagService->createTag($data);
        return new TagResource($tag);
    }

    public function update(UpdateTagRequest $request, $id)
    {
        $validatedData = $request->validated();
        $tag = $this->tagService->updateTag($id, $validatedData);
        return new TagResource($tag);
    }

    public function destroy($id)
    {
        $this->tagService->deleteTag($id);
        return response()->json(null, 204);
    }
}