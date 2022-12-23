<?php

namespace App\Services\ProfileServices;

class ChangeEmailService extends ProfileService
{
   public function execute($email): void
   {
       $this->usersRepository->changeEmail($email);
   }
}
