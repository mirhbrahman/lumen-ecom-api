<?php
namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use App\Services\ProductServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

class ProductsController extends Controller
{
  protected $products;
  public function __construct(ProductServices $services){
      $this->products = $services;
  }
  public function index(Request $request){
    $parameters = $request->input();
    $products = $this->products->getProducts($parameters);
    return response()->json($products);
  }

  public function show($id){
    $product = $this->products->getProduct($id);
    return response()->json($product);
  }

  public function store(Request $request){
    if($request->input('api_token')){
      $this->validate($request,[
        'category_id'=>'required|numeric',
        'sub_category_id'=>'required|numeric',
        'title'=>'required|min:2|max:100',
        'description'=>'required|min:3',
        'price'=>'required|numeric',
        'stok'=>'required|integer',
        'image'=>'required|image|mimes:jpg,jpeg,png',
      ]);
      return $this->products->createProduct($request);
    }else{
      return response()->json(['status'=>'somthing worng token not found'],400);
    }
  }

  public function update(Request $request,$id=null){
    if($request->input('api_token')){
      $this->validate($request,[
        'category_id'=>'required|numeric',
        'sub_category_id'=>'required|numeric',
        'title'=>'required|min:2|max:100',
        'description'=>'required|min:3',
        'price'=>'required|numeric',
        'stok'=>'required|integer',
        'image'=>'image|mimes:jpg,jpeg,png',
      ]);
      return $this->products->updateProduct($request,$id);
    }else{
        return response()->json(['status'=>'somthing worng'],400);
      }
  }


  public function destroy($id = null){
    $product = Product::findOrFail($id);
    if($product->delete()){
      return response()->json(['status'=>'Product Delete Successfull']);
    }else{
      return response()->json(['status'=>'Product Delete Fail'],400);
    }
  }
}

 ?>
