<?php
 
namespace App\Http\Controllers;
 
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;
 
class APITokenController extends Controller
{


public function varifyMobile(Request $request)
{
    $request->validate([
        'mobile' => 'required',
        
    ]);
    $user = User::where('mobile', $request->input('mobile'))->first();
 
    if (! $user ) {
        return [
            'error' => 'Mobile Number is not register.'
        ];
    }
    $randomSixDigitInt = \random_int(100000, 999999);
    $user = User::find($user->id);
        $user->otp = $randomSixDigitInt;
        $user->save();
    return  array(
            'status' => true,
            'otp' => $randomSixDigitInt,
            'mobile' => $request->input('mobile'),
        );
       
}







    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
           
            'mobile' => 'required|min:10',
            
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
            $user = User::where('mobile', $request->input('mobile')) 
            ->where('otp', $request->input('otp'))->first();
    
            if (! $user ) {
                return [
                    'error' => 'The provided credentials are incorrect.'
                ];
            }else{
                $user = User::find($user->id);
            $user->otp = '0';
            $user->save();
            }
        
            
            return  array(
                    'status' => true,
                    'token' =>  $user->createToken($request->input('mobile'))->plainTextToken
                );
            
        
    }
    public function dashboard(Request $request)
    {
        return  array(
            'status' => true,
            'data' =>  "dashboard"
        );
    }
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|min:10|unique:users,mobile',
            
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();









        return  array(
            'status' => true,
            'data' =>  "Register Successfuly"
        );
    }
}