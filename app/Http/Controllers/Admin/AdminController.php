<?php

namespace App\Http\Controllers\Admin;

// use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\Admin;
use Hash;
// use Image;
// use Intervention\Image\Facades\Image as Image;



class AdminController extends Controller
{
    public function dashboard() {
    	Session::put('page', 'dashboard');
    	return view('admin.admin_dashboard');
    }

    public function login(Request $request) {
    	// echo $password = Hash::make('12345'); die;
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		// echo "<pre>"; print_r($date); die;


			// $validated = $request->validate([
			//         'email' => 'required|email|max:255',
			//         'password' => 'required',
			//     ]);    		

// Custom validation 
    		$rules = [
				'email' => 'required|email|max:255',
				'password' => 'required',
    		];

    		$customMessage =[
    			'email.required' 	=> 	 'Email address is required',
    			'email.email'	 	=>	 'Valid email address is required',
    			'password.required' =>	 'Password is required',
    		];

    		$this->validate($request, $rules, $customMessage);
// End of custom validation

    		if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){
    			return redirect('admin/dashboard');
    		}else {
    			Session::flash('error_message', 'Invalid Email or Password');
    			return redirect()->back();
    		};
    	}
    	return view('admin.admin_login');
    }

    public function logout() {
    	Auth::guard('admin')->logout();
    	return redirect('/admin');
    }

    public function settings() {
    	Session::put('page', 'settings');
    	// echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
    	$adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
    	return view("admin.admin_settings")->with(compact('adminDetails'));
    }

    public function chkCurrentPassword(Request $request) {
    	$data = $request->all();
    	// echo "<pre>"; print_r($data); 
    	// echo "<pre>"; print_r(Auth::guard('admin')->user()->password ); die;
    	if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password )) {
    		echo "true";
    	}else {
    		echo "false";
    	}

    }

    public function updateCurrentPassword(Request $request) {
    	if($request->isMethod('post')) {
    		$data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		// Check if current password is correct or not 
    	if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password )) {
    		// check if new and conformed password is matching
    		if ($data['new_pwd']==$data['conform_pwd']) {
    			Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
    			Session::flash('success_message', "Password updated successfully !");
    		}else{
    		Session::flash('error_message', "New password and conform password not matching.");
    		}
    	}else{
    		Session::flash('error_message', "Your current password is incorrect");
    	}
    		return redirect()->back();    			
    	}
    }


    public function updateAdminDetails(Request $request) {
    	Session::put('page', 'update-admin-details');
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		$rules = [
    			'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
    			'admin_mobile' => 'required|numeric',
    			'admin_image'	=>	'mimes:jpeg,jpg,,png,gif'
    		];

    		$customMessage = [
    			'admin_name.required' => 'Name is required', 
    			'admin_name.regex' =>	'Name must be alphabetic only',
    			'admin_mobile.required'	=> 'Mobile number is required', 
    			'admin_mobile.numeric'	=> 'Mobile number must be numeric', 
    			'admin_image.mimes'	=> 'Only Jpeg, jpg, png and gif are accepted' 
    		];
    		$this->validate($request, $rules, $customMessage);
/**
    		// Image Upload Script
    		if ($request->hasFile('admin_image')) {
    			$image_tmp = $request->file('admin_image');
    			if($image_tmp->isValid()) {
    				// Get the image extensions
    				$extension = $image_tmp->getCLientOriginalExtension();
    				// Generate the new Image Name
    				$imageName = rand(111, 99999999).'.'.$extension;
    				$imagePath = 'images/admin_images/admin_photos/'.$imageName;
    				// Upload the image
    				Image::make($image_tmp)->save($imagePath);
    			}else if (!empty($data['current_admin_image'])) {
    				$imageName = $data['current_admin_image'];
    			}else{
    				$imageName = "";
    			}
    		}
**/
    		// Update admin details
    		Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'], 'mobile'=>$data['admin_mobile']]);
    		Session::flash('success_message', 'Admins Details Updated Successfully');
    		return redirect()->back();
    	}
    	return view('admin.update_admin_details');
    }
}
