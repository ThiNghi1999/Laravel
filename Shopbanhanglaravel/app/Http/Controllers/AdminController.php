<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;

use App\Social; //sử dụng model Social
use Socialite; //sử dụng Socialite
use App\Login; //sử dụng model Login

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();




class AdminController extends Controller
{

//login facebook
    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_id',$account_name->admin_id);
            Session::put('login_normal',true);
            Session::put('admin_name',$account_name->admin_name);

            return redirect('/dashbroad')->with('message', 'Đăng nhập Admin thành công');
        }else{

            $admin_login = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password'=> '',
                    'admin_phone' => '',
                  

                ]);
            }
           $admin_login->login()->associate($orang);
           $admin_login->save();

            $account_name = Login::where('admin_id',$admin_login->user)->first();
            Session::put('admin_id',$admin_login->admin_id);
            Session::put('login_normal',true);
            Session::put('admin_name',$admin_login->admin_name);
            
            return redirect('/dashbroad')->with('message', 'Đăng nhập Admin thành công');
        } 
    }
//login gg

public function login_google(){
        return Socialite::driver('google')->redirect();

   }

public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        $authUser = $this->findOrCreateUser($users,'google');
    if(  $authUser){

        $account_name = Login::where('admin_id',$authUser->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);
    }
       
        elseif($custmer_new){
        $account_name = Login::where('admin_id',$authUser->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);
        }
        return redirect('/dashbroad')->with('message', 'Đăng nhập Admin thành công');
      
       
    }
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }else{

             $custmer_new = new Social([
            'provider_user_id' => $users->id,
            'provider' => strtoupper($provider)
        ]);

        $orang = Login::where('admin_email',$users->email)->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $users->name,
                    'admin_email' => $users->email,
                    'admin_password' => '',
                    'admin_phone' => '',
                    
                ]);
            }
        $custmer_new->login()->associate($orang);
        $custmer_new->save();
        return $custmer_new;

        }
      


        $account_name = Login::where('admin_id',$$custmer_new->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);
        return redirect('/dashbroad')->with('message', 'Đăng nhập Admin thành công');


    }







    public function AuthLogin(){
        $admin_id=Session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashbroad');
            }
         else{
           return Redirect::to('admin')->send();

            }
    }
    public function index(){
    	return view('admin_login');
    }
    public function show_dashbroad(){
        $this->AuthLogin();
    	return view('admin.dashbroad');
    }
    public function dashbroad(Request $request){
    $data=$request->all();
    $admin_email=$data['admin_email'];
    $admin_password=md5($data['admin_password']);
    $login=Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    
    if($login){
        $login_count=$login->count();
    if($login_count>0){

       Session::put('admin_name',$login->admin_name);
       Session::put('admin_id',$login->admin_id);
       return Redirect::to('/dashbroad');

    }
   }
   else {
          Session::flash('alert-success','Mật khẩu và tài khoản bị sai làm ơn nhập lại!');
         return Redirect::to('/admin');
      }

}


   //code cũ    
   //  	$admin_email = $request->admin_email;
   //  	$admin_password = md5($request->admin_password);

   //  	$result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
   //  	    // echo '<pre>';
   //  	    // print_r($result) ;
   //  	    // echo '</pre>';
   //  	// first là lấy giới hạn 1 use
   //  	if($result){
   //  		Session::put('admin_name',$result->admin_name);
			// Session::put('admin_id',$result->admin_id);
			// return Redirect::to('/dashbroad');

   //  	}
   //  	else {
   //  		 Session::flash('alert-success','Mật khẩu và tài khoản bị sai làm ơn nhập lại!');
   //  		return Redirect::to('/admin');
   //  	}
   //  	return view('admin.dashbroad');
     public function logout(){
            $this->AuthLogin();
            Session::put('admin_name',null);
            Session::put('admin_id',null);
            return Redirect::to('/admin');
    }
}
