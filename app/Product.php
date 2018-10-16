<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['id','category_id','sub_category_id','title','description','stok','price'];

    public function sub_category(){
      return $this->belongsTo('App\SubCategory');
    }

    public function photo(){
      return $this->hasOne('App\Photo');
    }
}
