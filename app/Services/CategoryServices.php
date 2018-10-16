<?php
  namespace App\Services;
  use App\Category;
  class CategoryServices
  {
    public function getCategories(){
      $categories = Category::all();
      return response()->json($categories);
    }

    public function insertCategory($request=null){
      $category = $request->all();
      if (Category::create($category)) {
        return response()->json(['status'=>'Category create successfull'],201);
      }else{
        return response()->json(['status'=>'Somthing worng'],500);
      }
    }

    public function updateCategory($request,$id=null){
      $category = Category::findOrFail($id);
      if($category->update($request->all())){
        $category['status'] = 'update sucessfull';
        return response()->json($category,200);
      }
    }

    public function deleteCategory($id=null){
      $category = Category::findOrFail($id);
      if($category->delete()){
        $category['status'] = 'delete sucessfull';
        return response()->json($category,200);
      }
    }

  }

 ?>
