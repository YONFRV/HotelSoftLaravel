<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IAuthService;
use App\Util\UtilResponse;

class AuthService implements IAuthService
{
    protected $util;

    public function __construct(UtilResponse $util)
    {
        $this->util = $util;
    }

    public function loginProcess($request) { 

        $rules =[
            'email'=> 'required|email|max:100',
            'password'=> 'required|string'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'status' => false,
                'errors' => ['Unauthorized']
            ],401); 
        }
        $user = User::where('email',$request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'User logged suceessfully',
            'data' =>$user,
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ],200);
    }

    public function logoutProcess()
    {
        // Verifica si el usuario está autenticado
        if (auth()->check()) {
            // Revoca todos los tokens de acceso del usuario actual
            auth()->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User is not authenticated',
            ], 401); // Código de respuesta no autorizado
        }
    }

    public function createUserProcess($request){
        $rules =[
            'name' => 'required|string|max:100',
            'email'=> 'required|email|max:100|unique:users',
            'password'=> 'required|string|min:8'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $user = User::create([
            'name' => $request->name,'email'=> $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user -> updated_at = null;
        return response()->json([
            'status' => true,
            'message' => 'User creted suceessfully',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ],200);
    }

    public function updatePassword($request) {
        $rules=[
            'password' => 'required|min:8'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $user = Auth::user();
        $userData = User::where('email', $user->email)->first();
        if($userData){
                        // Hashea la nueva contraseña
            $newPassword = Hash::make($request->input('password'));
            // Actualiza la contraseña del usuario
            $userData->update(['password' => $newPassword]);
            return  $this->util->responseOk('Passwork update',$userData);
        }else{
            return $this->util->responseFail("User does not exist");

        }
    }

    public function byAuthProcess($request){
        $rules =[
            'email'=> 'required|email|max:100|unique:users'
        ];

        $user = User::where('email', $request->email)->first();
        if($user){
            return  $this->util->responseOk('User',$user);
        }
        else{
            return $this->util->responseFail("User does not exist");
        }
    }


    private function validateUserRequest($request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'password'=> 'required|string|min:8'
           ];
        return \Validator::make($request->input(), $rules);
    }
}