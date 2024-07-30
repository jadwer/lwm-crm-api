<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $products = ProductResource::collection(Product::filters($request)->paginate(10)->setPath(""))->resource;

        return response($products);
    }

    public function store(ProductStoreRequest $request): Response
    {
        if (isset($request->selectedImage)) {
            error_log("entro al if");
            error_log($request);
            Storage::disk('public')->putFileAs('products', $request->selectedImage, $request->img_path);
        }
        $product = Product::create($request->validated());

        return response(new ProductResource($product), 201);
    }

    public function show(Request $request, Product $product): Response
    {
        return response(new ProductResource($product));
    }

    public function update(ProductUpdateRequest $request, Product $product): Response
    {
        if (isset($request->selectedImage)) {
            error_log("entro al if");
            error_log($request);
            Storage::disk('public')->putFileAs('products', $request->selectedImage, $request->img_path);
        }
        $product->update($request->validated());

        return response(new ProductResource($product));
    }

    public function destroy(Request $request, Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
