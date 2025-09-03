<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Carbon\Carbon;
use App\Helpers\ApiResponseHelper;
use App\Http\Requests\ProductCategoryRequest;


class ProductCategoryController extends Controller
{
    public function addCategory(ProductCategoryRequest $request){
        try{
        $category = ProductCategory::create([
            'name'=> $request->name,
        ]);

        return ApiResponseHelper::success($category, 'Product Categories added successfully');
    }catch(\Exception $e){
        return response()->json([
            'success' => false,
        ], 500);
    }
    }
}
