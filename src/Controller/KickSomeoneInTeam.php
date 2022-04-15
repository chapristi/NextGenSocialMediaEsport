<?php


namespace App\Controller;


use App\Entity\UserJoinTeam;
use App\Repository\UserJoinTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class KickSomeoneInTeam extends AbstractController
{


    public function __construct
    (
        private EntityManagerInterface $entityManager,
        private Security $security
    )
    {}
    private function JsonReturn(string $message,int $code):JsonResponse
    {
        return $this->json([
            "infos" => $message,
            "code" => $code
        ],$code);
    }
    public function __invoke(string $token,UserJoinTeamRepository $joinTeamRepository):JsonResponse
    {
        $joinTeam = $this->entityManager->getRepository(UserJoinTeam::class)->findOneBy([
            "token" => $token
        ]);
        $user = $this->getUser();
        $ujt = $joinTeamRepository->findByExampleField($user,$joinTeam->getTeam());
        if (!$joinTeam){
            return $this->JsonReturn("token not valide",403);
        }
        if (!empty($ujt[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" || $this->security->isGranted("ROLE_ADMIN")) {
            $this->entityManager->remove($joinTeam);
            $this->entityManager->flush();
            return $this->JsonReturn("): the user has been kicked ",201);
        }else{
            return $this->JsonReturn("Unauthorized",403);
        }
    }
}