<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function index(Request $request): Response
    {
        // $brands = Brand::all();
        $brands = BrandResource::collection(Brand::all())->resource ;

        return response(new BrandCollection($brands));
    }

    public function store(BrandStoreRequest $request): Response
    {
        $brand = Brand::create($request->validated());

        return response(new BrandResource($brand), 201);
    }

    public function show(Request $request, Brand $brand): Response
    {
        return response(new BrandResource($brand));
    }

    public function update(BrandUpdateRequest $request, Brand $brand): Response
    {
        $brand->update($request->validated());

        return response(new BrandResource($brand));
    }

    public function destroy(Request $request, Brand $brand): Response
    {
        $brand->delete();

        return response()->noContent();
    }
}
