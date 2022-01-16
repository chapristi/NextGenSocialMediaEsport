<?php


namespace App\Controller;


use App\Entity\UserJoinTeam;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class AcceptSomeoneInTeam extends AbstractController
{
    public function __construct
    (
        private EntityManagerInterface $entityManager,
        private Security $security
    )
    {}
    public function __invoke($token):JsonResponse
    {
        $joinTeam = $this->entityManager->getRepository(UserJoinTeam::class)->findOneBy([
            "token" => $token
        ]);
        $user = $this->getUser();
        $ujt = $this->entityManager->getRepository(UserJoinTeam::class)->findByExampleField($user,$joinTeam);
        if (!$joinTeam){
            return $this->json([
                "infos" => "token not valide",
                "code" => 403
            ],403);
        }
        if (!empty($ujt[0]->getRole()[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" || $this->security->isGranted("ROLE_ADMIN")) {
            $joinTeam->setIsValidated(1);
            $this->entityManager->persist($joinTeam);
            $this->entityManager->flush();
            return $this->json([
                "infos" => "Bravo! l'utilisateur integre maitenant la team ",
                "code" => 200
            ],201);
        }else{
            return $this->json([
                "infos" => "Unauthorized",
                "code" => 403
            ],403);
        }
    }
}