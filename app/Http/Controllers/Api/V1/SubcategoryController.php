<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Services\SubcategoryService;

class SubcategoryController extends Controller
{
    protected $subcategoryService;

    public function __construct(SubcategoryService $subcategoryService)
    {
        $this->subcategoryService = $subcategoryService;
    }

    public function index()
    {
        return response()->json($this->subcategoryService->all());
    }

    public function store(StoreSubcategoryRequest $request)
    {
        return response()->json($this->subcategoryService->create($request->validated()), 201);
    }
    public function show($id)
    {
        return response()->json($this->subcategoryService->show($id));
    }

    public function update(StoreSubcategoryRequest $request, $id)
    {
        return response()->json($this->subcategoryService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->subcategoryService->delete($id);
        return response()->json(['message' => 'Subcategory deleted']);
    }
}

