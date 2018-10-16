<?php
namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryServices;

class CategoryController extends Controller
{
  protected $category;
  function __construct(CategoryServices $category)
  {
    $this->category = $category;
  }

  public function index(){
    return $this->category->getCategories();
  }

  public function store(Request $request){
    $this->validate($request,[
      'name'=>'required|min:2|max:100'
    ]);

    try {
      return $this->category->insertCategory($request);
    } catch (Exception $e) {
      return response()->json($e->getMessage,500);
    }
  }

  public function update(Request $request,$id=null){
    $this->validate($request,[
      'name'=>'required|min:2|max:100'
    ]);

    try {
      return $this->category->updateCategory($request,$id);
    } catch (Exception $e) {
      return response()->json($e->getMessage,500);
    }
  }

  public function destroy($id){
    try {
      return $this->category->deleteCategory($id);
    } catch (Exception $e) {
      return response()->json($e->getMessage,500);
    }
  }
}

 ?>
