<?php

namespace App\Controller;

use App\Entity\VerifMail;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;


class CheckMailController extends AbstractController
{
    public function __construct
    (
        private  EntityManagerInterface $entityManager
    )
    {}
    public function __invoke(string $token):?JsonResponse
    {
           $checkMail = $this->entityManager->getRepository(VerifMail::class)->findOneBy(["token" => $token]);
           if (!$checkMail){
               throw new  BadRequestException("le token n'est pas valide");
            }
            if (new DateTime() > $checkMail->getCreatedAt()->modify('+ 2 hour')){
                throw new  BadRequestException("le token a expiré");
            }
           $user= $checkMail->getUser();
           $user ->setIsVerified(true);
           $this->entityManager->remove($checkMail);
           $this->entityManager->persist($user);
           $this->entityManager->flush();
           return $this->json([
               "infos" => "le compte {$user->getEmail()} est verifié",
               "code" => 200
           ]);
    }
}
