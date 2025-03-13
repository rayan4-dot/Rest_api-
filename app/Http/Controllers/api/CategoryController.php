<?php



namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json([
            "categories" => $categories
        ]);
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = $this->categoryService->getSubcategories($categoryId);
        return CategoryResource::collection($subcategories);
    }


    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return new CategoryResource($category);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', 
        ]);

        $category = $this->categoryService->createCategory($data);
        return new CategoryResource($category);
    }


    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = $this->categoryService->updateCategory($id, $validatedData);
        return new CategoryResource($category);
    }


    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);
        return response()->json(null, 204);
    }
}
