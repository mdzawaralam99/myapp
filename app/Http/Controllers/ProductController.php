<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\ApiResponseHelper;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class ProductController extends Controller
{
    use AuthorizesRequests;
    public function addProduct(ProductRequest $request){
        $photoPath = null;
        //Gate::authorize('product.add');
        try {
            if($request->hasFile('photo')){
                // store in public storage under "products" folder I.e under \storage\app\public\products
                $photoPath = $request->file('photo')->store('products', 'public');
            }
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'photo' => $photoPath,
                'product_category_id' => $request->product_category_id,
            ]);

            return ApiResponseHelper::success($product, 'Product added successfully');
            }catch(\Exception $e){
                // this will run before the global handler
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to add Product',
                    'error' => $e->getMessage()
                ], 500);
            }
    }


    public function productList(){
        //try{
        $this->authorize('viewAny', Product::class);
        $product  = Product::where('status', true)->paginate(2);
        return ApiResponseHelper::paginated($product, "Product Fetched successfully", 200, ['Note' => 'These users are active']);
        /* }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch',
                'error' => $e->getMessage(),
            ], $e->getCode()?: 500);
        } */
        
    }

}
