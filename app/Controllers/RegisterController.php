<?php

namespace App\Controllers;

use App\Models\NewUser;
use App\Redirect;
use App\Services\RegisterService;
use App\Validation;
use App\View;

class RegisterController
{
    private Validation $validation;
    private RegisterService $registerService;

    public function __construct(Validation $validation, RegisterService $registerService)
    {
        $this->validation = $validation;
        $this->registerService = $registerService;
    }

    public function showForm(): View
    {
        return new View('register.twig');
    }

    public function register(): Redirect
    {
        $newUser=new NewUser($_POST['name'],$_POST['email'],$_POST['password'],$_POST['confirmPassword']);
        $_SESSION['user']['name']=$newUser->getName();
        $id=$this->validation->getId($newUser->getEmail());
        if ($id){
            $_SESSION['error']['email']='This email is already in use!';
            return new Redirect('/register');
        }
        $_SESSION['user']['email']=$newUser->getEmail();
        if ($newUser->getPassword()!=$newUser->getConfirmPassword()){
            $_SESSION['error']['password']='Passwords does not mach!';
            return new Redirect('/register');
        }
        $this->registerService->execute($newUser);
        $_SESSION['userId']=$this->validation->getId($newUser->getEmail());
        return new Redirect('/');
    }
}