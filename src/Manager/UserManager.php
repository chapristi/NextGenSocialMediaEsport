<?php
namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager{
    public function __construct(protected EntityManagerInterface $em, protected UserRepository $userRepository,protected UserPasswordHasherInterface $passwordService)
    {
        
    }    
    /**
     * findEmail
     *
     * @param  mixed $email
     * @return User|null
     */
    public function findEmail(string $email):User|null
    {
       $user =  $this -> userRepository -> findBy(["email" => $email]);
       if($user){
            return $user[0];
       } 
       return null;
    }
    public function registerAccount(User $user)
    {
        if($this -> findEmail($user -> getEmail())){
            throw new  BadRequestException("cette adresse email existe déjà");
        }
        $user->setEmail($user -> getEmail());
        $password = $this -> passwordService -> hashPassword(
            $user,
            $user -> getPassword(),
        );
        $user -> setPassword($password);
        $this -> em -> persist($user);
        $this -> em -> flush();
        return $user;
        
    }
}
    
   
