<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
class Cart extends Model
{
    protected $fillable = ['id','user_id','product_id','quantity','price_pu'];

    public function product(){
      return $this->belongsTo('App\Product');
    }
}
