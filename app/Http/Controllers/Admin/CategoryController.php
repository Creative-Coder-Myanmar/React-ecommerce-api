<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function show()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories
        ]);
    }
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:3']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $category = Category::create([
            'name' => request('name')
        ]);

        return response()->json([
            'message' => 'category created.',
            'category' => $category
        ]);
    }

    public function update(Category $category)
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:3']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $category->update([
            'name' => request('name')
        ]);

        return response()->json([
            'message' => 'category updated.',
            'category' => $category
        ]);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'delete successful.'
        ]);
    }
}
