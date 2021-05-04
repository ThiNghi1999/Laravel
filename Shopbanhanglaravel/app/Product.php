<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

public $timestamps = false;
    protected $fillable = [
          'categogy_id',  'product_name', 'product_quantity','product_sold', 'brand_id','product_desc','product_content','product_price','product_image','product_status'
    ];
 
    protected $primaryKey = 'product_id';
 	protected $table = 'tbl_product';
 	

}