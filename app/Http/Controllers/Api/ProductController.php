<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
  public function index()
  {
    return response()->json(Product::with('category', 'attributes')->get(), Response::HTTP_OK);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string',
      'category_id' => 'required|exists:categories,id',
      'attributes.*.id' => 'required|exists:attributes,id',
      'attributes.*.value' => 'required|string',
    ]);

    $product = Product::create([
      'name' => $validated['name'],
      'category_id' => $validated['category_id'],
    ]);

    $attributes = collect($validated['attributes'])->mapWithKeys(function ($item) {
      return [$item['id'] => ['value' => $item['value']]];
    });

    $product->attributes()->attach($attributes);

    return response()->json($product, Response::HTTP_CREATED);
  }

  public function show(Product $product)
  {
    return response()->json($product->load('attributes'), Response::HTTP_OK);
  }

  public function update(ProductRequest $request, Product $product)
  {
    $product->update($request->validated());
    $product->attributes()->sync($request->input('attributes', []));
    return response()->json($product->load('attributes'), Response::HTTP_OK);
  }

  public function destroy(Product $product)
  {
    $product->delete();
    return response()->json(null, Response::HTTP_NO_CONTENT);
  }
}
