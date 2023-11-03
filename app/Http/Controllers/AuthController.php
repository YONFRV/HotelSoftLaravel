<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Interfaces\IAuthService;
use App\Models\User;

class AuthController extends Controller
{

    protected $authService;
    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function create(Request $request){
        $response = $this->authService->createUserProcess($request); 
        return  $response ;
    }

    public function login(Request $request){
        $response = $this->authService->loginProcess($request); 
        return  $response ;
    }

    public function logout(){
        $response = $this->authService->logoutProcess();
        return  $response ;
    }

    public function updateData(Request $request)
    {
       $response = $this->authService->updatePassword($request); 
       return  $response ;
    }

    
    public function byData(Request $request)
    {
       $response = $this->authService->byAuthProcess($request); 
       return  $response ;
    }
}
