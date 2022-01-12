<?php

namespace App\Controller;

use App\Entity\VerifMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckMailController extends AbstractController
{
    public function __construct(private  EntityManagerInterface $entityManager){

    }
    public function __invoke($token){
           $checkMail = $this->entityManager->getRepository(VerifMail::class)->findOneBy(["token" => $token]);
           if (!$checkMail){
               throw new  BadRequestException("le token n'est pas valide");
            }
            if (new  \DateTime() > $checkMail -> getCreatedAt()->modify('+ 5 hour')){
                throw new  BadRequestException("le token a expiré");
            }
           $user= $checkMail->getUser();
           $user ->setIsVerified(true);
           $this->entityManager->persist($user);
           $this->entityManager->flush();
           return $this->json([
               "infos" => "le compte {$user->getEmail()} est verifié",
               "code" => 200
           ],200);
    }
}
