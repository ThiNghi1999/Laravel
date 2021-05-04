<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();



class CouponController extends Controller
{
    public function unset_coupon(){
        $coupon=Session::get('coupon');
        if($coupon==true){
        Session::forget('coupon');
        return Redirect()->back()->with('alert-success','Xóa mã giảm giá thành công');
    }
    }
	public function delete_coupon($coupon_id){
		$coupon=Coupon::find($coupon_id);
		$coupon->delete();
		Session::flash('alert-success','xóa mã giảm giá thành công');
    	return Redirect::to('list-coupon');
		//fine() thuộc tính fine thường tác động đến trường id
	}

	 public function list_coupon(){
     $coupon=Coupon::orderby('coupon_id','DESC')->get();


    	return view('admin.coupon.list_coupon')->with(compact('coupon'));
    }
    public function insert_coupon(){
    	return view('admin.coupon.insert_coupon');
    }

    public function insert_coupon_code(Request $request){
    $data=$request->all();
    $coupon=new Coupon;
    $coupon->coupon_name=$data['coupon_name'];
    $coupon->coupon_code=$data['coupon_code'];
    $coupon->coupon_time=$data['coupon_time'];
    $coupon->coupon_number=$data['coupon_number'];
    $coupon->coupon_condition=$data['coupon_condition'];
    $coupon->save();

    // Session::put('message','Thêm mã giảm giá thành công');
    Session::flash('alert-success','Thêm mã giảm giá thành công');
    return Redirect::to('list-coupon');

    }
}
