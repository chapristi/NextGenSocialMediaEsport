<?php

namespace App\Controller;

use App\Repository\BFFRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceptFriendRequestController extends AbstractController
{
    public function __construct
    (
        private BFFRepository $BFFRepository,
        private EntityManagerInterface $entityManager,
    )
    {}
    private function JsonReturn(string $message, int $code):JsonResponse
    {
        return $this->json([
            "infos" => $message,
            "code" => $code
        ],$code);
    }

    public function __invoke(string $token)
   {
      $bff = $this->BFFRepository->findOneBy(["token" => $token]);
      if(!$bff){
          $this->JsonReturn("token don't exist",403);
      }
      if ($bff->getReceiver() === $this->getUser()){
          $bff->setIsAccepted(true);
          $this->entityManager->persist($bff);
          $this->entityManager->flush();
          $this->JsonReturn("Awesome you are know friend",200);
      }
       $this->JsonReturn("a problem has occurred",403);
   }
}
