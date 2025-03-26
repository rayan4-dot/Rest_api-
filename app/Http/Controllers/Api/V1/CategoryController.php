<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;



class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return response()->json($this->categoryService->all());
    }

    public function store(StoreCategoryRequest $request)
    {
        return response()->json($this->categoryService->store($request->validated()), 201);
    }

    public function show($id)
    {
        return response()->json($this->categoryService->show($id));
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        return response()->json($this->categoryService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);
        return response()->json(null, 204);
    }
}
