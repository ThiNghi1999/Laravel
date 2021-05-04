<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Slider;

class HomeController extends Controller
{
    public function index(Request $request){
      //slider
      $slider=Slider::orderby('slider_id','DESC')->where('slider_status','0')->take(4)->get();

    	$cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
     	$brand_product=DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();


		$all_product=DB::table('tbl_product')->where('product_status','0')->orderby('product_id','desc')->limit(4)->get();

    return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)->with('slider',$slider);

   
    }
    public function san_pham(){
      $slider=Slider::orderby('slider_id','DESC')->where('slider_status','0')->take(4)->get();

      $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
      
      $brand_product=DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();


     $product=DB::table('tbl_product')->where('product_status','0')->orderby('product_id','desc')->get();


    return view('pages.sanpham.product')->with('category',$cate_product)->with('brand',$brand_product)->with('product',$product)->with('slider',$slider);
    }
    public function search(Request $request){
      $keywords=$request->keywords_submit;
      $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
      $brand_product=DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
      $search_product=DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();
      $slider=Slider::orderby('slider_id','DESC')->where('slider_status','0')->take(4)->get();

     return view('pages.sanpham.searchsp')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product)->with('slider',$slider);
    }
}
