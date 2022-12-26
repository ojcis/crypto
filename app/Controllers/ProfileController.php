<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\ProfileServices\AddMoneyService;
use App\Services\ProfileServices\ChangeEmailService;
use App\Services\ProfileServices\ChangeNameService;
use App\Services\ProfileServices\ChangePasswordService;
use App\Services\ProfileServices\DeleteAccountService;
use App\Services\ProfileServices\ShowUserCoinsService;
use App\Services\ProfileServices\ShowUserShortsService;
use App\Services\ProfileServices\WithdrawMoneyService;
use App\Validation;
use App\View;

class ProfileController
{
    private Validation $validation;
    private ChangeNameService $changeNameService;
    private ChangeEmailService $changeEmailService;
    private ChangePasswordService $changePasswordService;
    private DeleteAccountService $deleteAccountService;
    private AddMoneyService $addMoneyService;
    private WithdrawMoneyService $withdrawMoneyService;
    private ShowUserCoinsService $showUserCoinsService;
    private ShowUserShortsService $showUserShortsService;

    public function __construct(
        Validation $validation,
        ChangeNameService $changeNameService,
        ChangeEmailService $changeEmailService,
        ChangePasswordService $changePasswordService,
        DeleteAccountService $deleteAccountService,
        AddMoneyService $addMoneyService,
        WithdrawMoneyService $withdrawMoneyService,
        ShowUserCoinsService $showUserCoinsService,
        ShowUserShortsService $showUserShortsService
    )
    {
        $this->validation = $validation;
        $this->changeNameService = $changeNameService;
        $this->changeEmailService = $changeEmailService;
        $this->changePasswordService = $changePasswordService;
        $this->deleteAccountService = $deleteAccountService;
        $this->addMoneyService = $addMoneyService;
        $this->withdrawMoneyService = $withdrawMoneyService;
        $this->showUserCoinsService = $showUserCoinsService;
        $this->showUserShortsService = $showUserShortsService;
    }

    public function showForm(): View
    {
        $button = $_GET['show'] ?? 'profileInfo';
        return new View('profile.twig',[
            $button => true,
        ]);
    }

    public function changeName():Redirect
    {
        $id=$_SESSION['userId'];
        $newName=$_POST['name'];
        $password=$_POST['password'];
        $_SESSION['user']['newName']=$newName;
        if(!$this->validation->validatePassword($id,$password)){
            $_SESSION['error']['password']='Wrong password!';
            return new Redirect("/profile?show=changeName");
        }
        $this->changeNameService->execute($newName);
        return new Redirect('/profile?show=profileInfo');
    }

    public function changeEmail():Redirect
    {
        $id=$_SESSION['userId'];
        $newEmail=$_POST['email'];
        $password=$_POST['password'];
        if ($this->validation->getId($newEmail)){
            $_SESSION['error']['email']='This email is already in use!';
            return new Redirect("/profile?show=changeEmail");
        }
        $_SESSION['user']['newEmail']=$newEmail;
        if(!$this->validation->validatePassword($id,$password)){
            $_SESSION['error']['password']='Wrong password!';
            return new Redirect("/profile?show=changeEmail");
        }
        $this->changeEmailService->execute($newEmail);
        return new Redirect('/profile?show=profileInfo');
    }

    public function changePassword():Redirect
    {
        $id=$_SESSION['userId'];
        $newPassword=$_POST['newPassword'];
        $confirmNewPassword=$_POST['confirmNewPassword'];
        $password=$_POST['password'];
        if ($newPassword!=$confirmNewPassword){
            $_SESSION['error']['password']='New passwords does not mach!';
            return new Redirect("/profile?show=changePassword");
        }
        if(!$this->validation->validatePassword($id,$password)){
            $_SESSION['error']['password']='Wrong password!';
            return new Redirect("/profile?show=changePassword");
        }
        $this->changePasswordService->execute($newPassword);
        return new Redirect('/profile?show=profileInfo');
    }

    public function deleteAccount(): Redirect
    {
        $id=$_SESSION['userId'];
        $password=$_POST['password'];
        if(!$this->validation->validatePassword($id,$password)){
            $_SESSION['error']['password']='Wrong password!';
            return new Redirect("/profile?show=deleteAccount");
        }
        $this->deleteAccountService->execute();
        unset($_SESSION['userId']);
        return new Redirect('/');
    }
    public function addMoney(): Redirect
    {
        $id=$_SESSION['userId'];
        $amount=$_POST['addMoney'];
        $password=$_POST['password'];
        if(!$this->validation->validatePassword($id,$password)){
            $_SESSION['error']['password']='Wrong password!';
            return new Redirect("/profile?show=addMoney");
        }
        $this->addMoneyService->execute($amount);
        return new Redirect('/profile?show=profileInfo');
    }

    public function withdrawMoney(): Redirect
    {
        $id=$_SESSION['userId'];
        $amount=$_POST['withdrawMoney'];
        $password=$_POST['password'];
        if(!$this->validation->validatePassword($id,$password)){
            $_SESSION['error']['password']='Wrong password!';
            return new Redirect("/profile?show=withdrawMoney");
        }
        $this->withdrawMoneyService->execute($amount);
        return new Redirect('/profile?show=profileInfo');
    }

    public function showUserCoins(array $vars): View
    {
        $userCoinsInfo=$this->showUserCoinsService->execute($vars['userId'])->getUserCoinValueCollection();
        $userShortsInfo=$this->showUserShortsService->execute($vars['userId'])->getUserShortValueCollection();
        return new View('userCoins.twig',[
            'userCoins' => $userCoinsInfo,
            'userShorts' => $userShortsInfo
        ]);
    }


}
