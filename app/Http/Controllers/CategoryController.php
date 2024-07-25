<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = CategoryResource::collection(Category::all())->resource ;
//        $categories = Category::all();

        return response(new CategoryCollection($categories));
    }

    public function store(CategoryStoreRequest $request): Response
    {
        $category = Category::create($request->validated());

        return response(new CategoryResource($category), 201);
    }

    public function show(Request $request, Category $category): Response
    {
        return response(new CategoryResource($category));
    }

    public function update(CategoryUpdateRequest $request, Category $category): Response
    {
        $category->update($request->validated());

        return response(new CategoryResource($category));
    }

    public function destroy(Request $request, Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
