<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use Redirect;
use Sentinel;

use App\User as MasterModel;

class AuthController extends Controller
{
    public function getLogin()
    {
        $active = 'index';
        $word = trans('auth.word');

    	return view('auth.login', compact('active','word'));
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = [
		    'email' => $request->email,
		    'password' => $request->password
		];

		if(Sentinel::authenticate($credentials)){
            if(Sentinel::getUser()->role_id == 1){
                return Redirect::route('users')->with('success', trans('auth.login.success'));
            }else if(Sentinel::getUser()->role_id == 2){
                return Redirect::route('sales')->with('success', trans('auth.login.success'));
            }else if(Sentinel::getUser()->role_id == 3){
                return Redirect::route('finances')->with('success', trans('auth.login.success'));
            }else if(Sentinel::getUser()->role_id == 4){
                return Redirect::route('buildings')->with('success', trans('auth.login.success'));
            }else if(Sentinel::getUser()->role_id == 5){
                return Redirect::route('shippings')->with('success', trans('auth.login.success'));
            }else{
                Sentinel::logout();
                return Redirect::route('auth')->with('error', trans('auth.login.error'));
            }
		}else{
			return Redirect::back()->with('error', trans('auth.login.error'));
		}
    }

    public function logout()
    {
    	if(Sentinel::logout()){
			return Redirect::route('auth')->with('success', trans('auth.logout.success'));
		}else{
			return Redirect::back()->with('error', trans('auth.logout.error'));
		}
    }

    // public function getForgotPassword()
    // {
    //     $active = 'index';
    //     $cart = Session::get('cart');
        
    // 	return view('auth.forgot-password', compact($this->compact));
    // }
    
    // public function postForgotPassword(Request $request)
    // {
    // 	$count = MasterModel::withTrashed()->where('email', $request->email)->count();
    // 	if($count <= 0){
    // 		return Redirect::back()->with('error', trans('passwords.user'));
    // 	}

    //     $deleted_at = MasterModel::withTrashed()->where('email', $request->email)->first()->deleted_at;
    //     if($deleted_at != null){
    //         return Redirect::back()->with('error', trans('auth.title.email_deleted'));
    //     }

    //     $status = MasterModel::withTrashed()->where('email', $request->email)->first()->status_id;
    //     if($status != 1){
    //         return Redirect::back()->with('error', trans('auth.title.email_banned'));
    //     }

    //     $user = Sentinel::findById(MasterModel::withTrashed()->where('email', $request->email)->first()->id);
    //     $activation = Activation::completed($user);
    //     if (!$activation) {
    //         return Redirect::back()->with('error', trans('auth.title.email_banned'));
    //     }

    //     $reminder = Reminder::exists($user) ?: Reminder::create($user);
    //     // Data to be used on the email view
    //     $data = [
    //         'user' => $user,
    //         'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$user->id, $reminder->code]),
    //     ];

    //     // Send the activation code through email
    //     SendMail::createMailForgotPassword($data);

    //     return Redirect::back()->with('success', trans('passwords.sent'));
    // }
    
    // public function getForgotPasswordConfirm($id, $passwordResetCode = null)
    // {
    //     $active = 'index';
    //     $cart = Session::get('cart');
        
    //     // Find the user using the password reset code
    //     if(!$user = Sentinel::findById($id))
    //     {
    //         // Redirect to the forgot password page
    //         return Redirect::route('forgot-password')->with('error', trans('passwords.user'));
    //     }

    //     if($reminder = Reminder::exists($user))
    //     {
    //         if($passwordResetCode == $reminder->code)
    //         {
    //             return view('auth.forgot-password-confirm', compact($this->compact));
    //         }
    //         else{
    //             return Redirect::route('forgot-password')->with('error', trans('passwords.token'));
    //         }
    //     }
        
    //     return Redirect::route('forgot-password')->with('error', trans('passwords.token'));
    // }
    
    // public function postForgotPasswordConfirm(Request $request, $id, $passwordResetCode = null)
    // {
    // 	// Find the user using the password reset code
    //     $user = Sentinel::findById($id);
    //     if (!$reminder = Reminder::complete($user, $passwordResetCode, $request->password))
    //     {
    //         // Ooops.. something went wrong
    //         return Redirect::route('login')->with('error', trans('auth.forgot-password-confirm.error'));
    //     }

    //     // Password successfully reseted
    //     return Redirect::route('login')->with('success', trans('passwords.reset'));
    // }
}
