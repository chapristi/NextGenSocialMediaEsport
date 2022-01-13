<?php


namespace App\Controller\Api;

use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CreateUser extends AbstractController
{
    public function __construct(protected UserManager $userManager)
    {

    }
    public function __invoke (User $data)
    {

        $this -> userManager ->registerAccount($data);
        return $data;

    }
}