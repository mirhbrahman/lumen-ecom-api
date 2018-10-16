<?php
namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class AdminsController extends Controller
{
  public function login(Request $request){
    if(!empty($request->input('email')) && !empty($request->input('password'))){
      $email = $request->input('email');
      $password = $request->input('password');
      //.........finding user
      $user = User::where(['email'=>$email])->take(1)->get()->first();
      if(!empty($user)){
        if(Hash::check($password,$user->password)){
          //........if login give user a api_token
          if(!empty($user->api_token)){
            return response()->json([
              'name'=>$user->name,
              'email'=>$user->email,
              'api_token'=>$user->api_token
            ]);
          }else{
            //........no api token create a token
            $api_token = str_random(60);
            $user->api_token = $api_token;
            $user->update();

            return response()->json([
              'name'=>$user->name,
              'email'=>$user->email,
              'api_token'=>$api_token
            ]);
          }
        }else{
          return response()->json(['status'=>'Email/Password does not match 1'],404);
        }
      }else{
        return response()->json(['status'=>'Email/Password does not match 2'],404);
      }
    }else{
      return response()->json(['status'=>'Email/Password does not match 3'],404);
    }
  }
}

 ?>
