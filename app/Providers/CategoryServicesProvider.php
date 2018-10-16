<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Services\CategoryServices;

class CategoryServicesProvider extends ServiceProvider
{
  public function register(){
    $this->app->singleton(CategoryServices::class,function($app){
      return new CategoryServices();
    });
  }
}

?>
