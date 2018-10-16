<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubCategory;
use App\Photo;

class ProductServices
{
  protected $photo_base_url = 'C:\xampp\htdocs\laraEcom2\public\images\products/';
  //..........return all products
  public function getProducts($parameters){
    //........if not set any Category
    if(empty($parameters)){
      return $this->filter(Product::all());
    }

    //......if set any category
    if(isset($parameters['cat_id'])){
      $cat_id = $parameters['cat_id'];
      return $this->filter(Product::where('category_id',$cat_id)->get());
    }

    //......if set any sub category
    if(isset($parameters['sub_cat_id'])){
      $sub_cat_id = $parameters['sub_cat_id'];
      return $this->filter(Product::where('sub_category_id',$sub_cat_id)->take(1)->get());
    }


  }
  //..........return single product
  public function getProduct($id=null){
    $product = Product::where('id',$id)->take(1)->get();
    return $this->filter($product);
  }

  //.........filter record for client
  public function filter($productsList){
    $products = [];
    foreach ($productsList as $product) {
      $entry = [
        'id'=>$product->id,
        'cat_id' => $product->category_id,
        'sub_cat_id' => $product->sub_category_id,
        'title'=>$product->title,
        'description'=>$product->description,
        'price'=> $product->price,
        'photo_url'=> $this->photo_base_url.$product->photo->name,
      ];
      $products[] = $entry;
    }
    return $products;
  }


  //...........create product
  public function createProduct($request){
      if($product = Product::create($request->all())){
        if($image = $request->file('image')){
          $name = $product->id.rand(1000,1999).round(time()).'.'.$image->getClientOriginalExtension();
          $image->move($this->photo_base_url,$name);
          if(Photo::create(['product_id'=>$product->id,'name'=>$name])){
          }else{
            return response()->json(['status'=>'somthing worng in image upload'],500);
          }
        }
        return response()->json(['status'=>'product create succssfull'],201);
      }else{
        return response()->json(['status'=>'somthing worng'],500);
      }

    }


    //........update product
    public function updateProduct($request,$id = null){
      $product = Product::findOrFail($id);
        if($product->update($request->all())){
          if($image = $request->file('image')){
            $name = $product->photo->name;
            $image->move($this->photo_base_url,$name);

            //.....check if photo created or not
            $photo = Photo::where('product_id',$product->id)->first();
            if(empty($product)){
              if(Photo::create(['product_id'=>$product->id,'name'=>$name])){
              }else{
                return response()->json(['status'=>'somthing worng in image upload'],500);
              }
            }

          }
          return response()->json([
            'product_id' => $product->id,
            'status'=>'product update succssfull'
          ],201);
        }else{
          return response()->json(['status'=>'somthing worng'],500);
        }

      }


}

?>
