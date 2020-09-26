<?php
namespace App\User\Service;

use App\User\Repository\AuthRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\User\UserDetailVO;

class AuthService
{

    protected $repo;

    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }


      /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] mobile_no
     * @param  [string] mobile_no_2
     * @param  [string] mobile_no_3
     * @param  [string] password_confirmation
     * @return [string] message
     */
   public function register($data)
   {
     //  dd($data);
       // $data = (object) $data;
        $validator = Validator::make($data,[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'mobileNo' => 'required',
            'mobileNo2' => 'required',
            'mobileNo3' => 'required',
            'password' => 'required'
        ]);
           // dd($validator);
        if ($validator->fails()) {
           
            $errors = $validator->messages();

            return response()->json(["message"=>"FAILED","data"=>$errors]);
        }

        $model = $this->convertToModel($data);
        $response =  $this->repo->store($model);

        return $response;
   }


       /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
   public function login($data){
    
   

    $validator = Validator::make($data,[
        'mobileNo' => 'required|string',
        'password' => 'required|string'       
    ]);

    if ($validator->fails()) {
       
        $errors = $validator->errors();

        return response()->json(["message"=>"FAILED","data"=>$errors]);
    }

    $user = "";

    $data = (object) $data;

    if(Auth::attempt(['mobile_no'=>$data->mobileNo,"password"=>$data->password])){

        $user = Auth::user();
    }else  if(Auth::attempt(['mobile_no_2'=>$data->mobileNo,"password"=>$data->password])){
        $user = Auth::user();
    }else if(Auth::attempt(['mobile_no_3'=>$data->mobileNo,"password"=>$data->password])){
        $user = Auth::user();
    }else{

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    if($user){
      //  dd($user);
        $tokenResult = $user->createToken($user->name);
        $token = $tokenResult->token;
        $token->save();
    }

    return response()->json(["message" => "SUCCESS","data"=>[
        "user"=> Auth::user(),
        'access_token' => $tokenResult->accessToken
    ]]);
   }


   public function getAuthUser(){

    $data = Auth::user();
    return response()->json(["message" => "SUCCESS","data"=>$data]);
   }

   /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
   public function logout(){

        Auth::user()->token()->revoke();
        return response()->json([
        "message" => "SUCCESS","data"=>"Logout Successfully!"
                ]);

   }
   public function convertToModel($data){

    $data = (object) $data;
    $model = new User([
        'name' => $data->name,
        'email' => $data->email,
        'mobile_no' => $data->mobileNo,
        'mobile_no_2' => $data->mobileNo2,
        'mobile_no_3' => $data->mobileNo3,
        'password' => bcrypt($data->password)
    ]);

    return $model;
   }
}
