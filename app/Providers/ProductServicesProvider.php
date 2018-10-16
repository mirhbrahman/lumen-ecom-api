<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Services;

class ProductServicesProvider extends ServiceProvider
{
  public function register(){
    $this->app->singleton(ProductServices::class,function($app){
      return new ProductServices();
    });
  }
}

 ?>
