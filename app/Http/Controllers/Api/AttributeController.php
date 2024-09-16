<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttributeController extends Controller
{
  public function index()
  {
    return response()->json(Attribute::all(), Response::HTTP_OK);
  }

  public function store(AttributeRequest $request)
  {
    $attribute = Attribute::create($request->validated());
    return response()->json($attribute, Response::HTTP_CREATED);
  }

  public function show(Attribute $attribute)
  {
    return response()->json($attribute, Response::HTTP_OK);
  }

  public function update(AttributeRequest $request, Attribute $attribute)
  {
    $attribute->update($request->validated());
    return response()->json($attribute, Response::HTTP_OK);
  }

  public function destroy(Attribute $attribute)
  {
    $attribute->delete();
    return response()->json(null, Response::HTTP_NO_CONTENT);
  }
}
