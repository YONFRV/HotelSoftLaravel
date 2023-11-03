<?php

namespace App\Interfaces;

interface IAuthService
{
    public function loginProcess($request);
    public function logoutProcess();
    public function createUserProcess($request);
    public function updatePassword( $request);
    public function byAuthProcess($request);
}