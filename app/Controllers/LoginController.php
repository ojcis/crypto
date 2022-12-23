<?php

namespace App\Controllers;

use App\Redirect;
use App\Validation;
use App\View;

class LoginController
{
    private Validation $validation;

    public function __construct(Validation $validation)
    {
        $this->validation = $validation;
    }

    public function showForm(): View
    {
        return new View('login.twig');
    }

    public function login(): Redirect
    {
        $email=$_POST['email'];
        $password=$_POST['password'];
        $id=$this->validation->getId($email);
        if (!$id){
            $_SESSION['error']['email']='Wrong email!';
            return new Redirect('/login');
        }
        $_SESSION['user']['email']=$email;
        if (!$this->validation->validatePassword($id,$password)){
            $_SESSION['error']['password']='Wrong password!';
            return new Redirect('/login');
        }
        $_SESSION['userId']=$id;
        return new Redirect('/');
    }
}
