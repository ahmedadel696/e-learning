<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use TCG\Voyager\Http\Controllers\VoyagerAuthController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;

class AccountController extends Controller
{
    use AuthenticatesUsers;
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // if ($username && $password) {
        //     $this->validateLogin($request);
        //     $response = $this->getResponse(0, "notallowed");
        // }
        if ($username && $password) {
            $this->validateLogin($request);
            $user = User::where('username', $username)->first();
            if ($user && $user->id) {
                if ($user->role_id == 1) {
                    $credentials = $this->credentials($request);
                    if ($this->guard()->attempt($credentials, $request->has('remember'))) {

                        $response =  $this->getResponse(1, "login success", $user);
                    } else {
                        $response =  $this->getResponse(0, "login faild");
                    }
                } else {
                    $response = $this->getResponse(0, "notallowed");
                }
            }else{
                $response =  $this->getResponse(0, 'notFound'); 
            }
        } else {
            $response =  $this->getResponse(0, 'paramaters missing');
        }

        return response($response)->header('Content-Type', 'application/json');
    }
    public function profile($userid)
    {
        $user = User::where('id', $userid)->first();
        $data = [];
        if ($user && $user->id) {

            $data[] = [
                'firstname' => $user->first_name,
                'lastname' => $user->last_name,
                'contactNo' => $user->contact_no,
                'email' => $user->email,
                'image' => $user->avatar,
                'username' => $user->username,

            ];
            $response =  $this->getResponse(1, '', $data);
        } else {
            $response =  $this->getResponse(0, "notFound");
        }
        return response($response)->header('Content-Type', 'application/json');
    }

    public function updateProfile(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();

        if ($user && $user->id) {
            $user->first_name = $request->first_name ?? $user->first_name;
            $user->last_name = $request->last_name ?? $user->last_name;
            $user->contact_no = $request->contact_no ?? $user->contact_no;
            $user->avatar = $request->avatar ?? $user->avatar;
            $user->save();
            $response =  $this->getResponse(1, 'profile updated succesfully');
        } else {
            $response =  $this->getResponse(0, 'notFound');
        }
        return response($response)->header('Content-Type', 'application/json');
    }
}
