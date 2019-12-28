<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $user->fcm_token = request('fcm_token');
            $user->save();
            $user['token'] =  $user->createToken('nApp')->accessToken;
            return response()->json(['error' => FALSE, 'user' => $user], $this->successStatus);
        }
        else{
            return response()->json(['error_msg'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error_msg'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['error'=> FALSE, 'success'=>$success], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json($user, $this->successStatus);
    }

    public function gantipassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        $newpassword = bcrypt($request->password);
        // return $newpassword;
        if ($validator->fails()) {
            return response()->json(['error_msg'=>$validator->errors()], 401);            
        } 
        // return $request;
        $user = User::findOrFail($request->id);
        if (Hash::check($request->oldpassword, $user->password)) { 
            $user->fill(['password' => Hash::make($request->password)])->save();
            $user['token'] =  $user->createToken('nApp')->accessToken;
            return response()->json(['error' => FALSE, 'user' => $user], $this->successStatus);
        }
    }


    public function editprofile(Request $request)
    {
        // return response()->json(['error' => FALSE, 'user' => $request], $this->successStatus);
        if($request->hasFile('image')) {
            $destinationPath = public_path('/profileimages/');
            $image = $request->file('image');
            $filename = $request->filename;
            $savedFileName = "profile_".date('Ymdhis')."_".$filename;
            $image->move($destinationPath, $savedFileName);
        } else{
            $savedFileName = "ini profile image";
        }

        $user = User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'notelp' => $request->notelp,
            'profile_image' => $savedFileName
            ]);
        return response()->json(['error' => FALSE, 'user' => $user], $this->successStatus);
    }

    public function uploadktp(Request $request)
    {
        if($request->hasFile('image')) {
            $destinationPath = public_path('/ktp/');
            $image = $request->file('image');
            // $filename = $image->getClientOriginalName();
            $filename = $request->filename;
            $savedFileName = "ktp_".date('Ymdhis')."_".$filename;
            $image->move($destinationPath, $savedFileName);
        }

        $user = User::where('id', $request->id)->update([
            'ktp' => $savedFileName
            ]);
        return response()->json(['error' => FALSE, 'user' => $user], $this->successStatus);
    }

    public function logout()
    {
        $user = Auth::logout();
        return response()->json(['success' => $user], $this->successStatus);
    }

        
}
