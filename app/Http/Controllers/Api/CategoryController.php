<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
  public function index()
  {
    return response()->json(Category::all(), Response::HTTP_OK);
  }

  public function store(CategoryRequest $request)
  {
    $category = Category::create($request->validated());
    return response()->json($category, Response::HTTP_CREATED);
  }

  public function show(Category $category)
  {
    return response()->json($category, Response::HTTP_OK);
  }

  public function update(CategoryRequest $request, Category $category)
  {
    $category->update($request->validated());
    return response()->json($category, Response::HTTP_OK);
  }

  public function destroy(Category $category)
  {
    $category->delete();
    return response()->json(null, Response::HTTP_NO_CONTENT);
  }
}
