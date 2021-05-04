<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Slider;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class SliderController extends Controller
{
	 public function AuthLogin(){
        $admin_id=Session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashbroad');
            }
         else{
           return Redirect::to('admin')->send();

            }
        
    }
    public function manage_slider(){
    	$this->AuthLogin();
    	$all_slide=Slider::orderby('slider_id','DESC')->get();
    	return view('admin.slider.list_slider')->with(compact('all_slide'));
    }
    public function add_slider(){
    	$this->AuthLogin();

    	return view('admin.slider.add_slider');
    }
    public function insert_slider(Request $request){
    $this->AuthLogin();
    $data=$request->all();

   
    	$get_image=$request->file('slider_image');
    	if($get_image){
    		$get_name_image = $get_image->getClientOriginalName();
    		//phân tách chuỗi dựa vào dấu chấm
    		$name_image = current(explode('.',$get_name_image));
    		//rand(0,99) thêm vào số để không trùng tên ảnh khi thêm vào
    		$new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    		$get_image->move('uploads/slider',$new_image);
    		//$data['slider_image'] = $new_image;


		    $slider=new Slider();
		    $slider->slider_name=$data['slider_name'];
		    $slider->slider_image=$new_image;
		    $slider->slider_desc=$data['slider_desc'];
		    $slider->slider_status=$data['slider_status'];

    		$slider->save();

    		Session::flash('alert-success','Thêm slider thành công');
    		Return Redirect::to('manage-slider');
    	}
    	else{
    
    	Session::flash('alert-success','Làm ơn thêm hình ảnh');
        return Redirect::to('/manage-slider');
		}
    	
    }
    public function unactive_slide($slider_id){
    	$this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>1]);
       Session::flash('alert-success','Không kích hoạt slider thành công');
        return Redirect::to('/manage-slider');
    }
    public function active_slide($slider_id){
    	$this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>0]);
        Session::flash('alert-success','Kích hoạt slider thành công');
        return Redirect::to('/manage-slider');
    }
     public function delete_slide($slider_id){
        $this->AuthLogin();
       DB::table('tbl_slider')->where('slider_id',$slider_id)->delete();
       Session::flash('alert-success','Xóa slider thành công');
       return Redirect::to('manage-slider');
    }
   
}
