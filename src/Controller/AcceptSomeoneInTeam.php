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
    private function JsonReturn(string $message,int $code):JsonResponse
    {
        return $this->json([
            "infos" => $message,
            "code" => $code
        ],$code);
    }
    public function __invoke($token):JsonResponse
    {
        $joinTeam = $this->entityManager->getRepository(UserJoinTeam::class)->findOneBy([
            "token" => $token
        ]);

        if ($joinTeam->getIsValidated() === true){
            return $this->JsonReturn("l'utilisateur semble deja etre vérifié ",403);

        }
        $user = $this->getUser();
        $ujt = $this->entityManager->getRepository(UserJoinTeam::class)->findByExampleField($user,$joinTeam->getTeam());
        if (!$joinTeam){
            return $this->JsonReturn("token not valide",403);
        }




        if (!empty($ujt[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" || $this->security->isGranted("ROLE_ADMIN")) {

            $joinTeam->setIsValidated(1);
            $this->entityManager->persist($joinTeam);
            $this->entityManager->flush();
            return $this->JsonReturn("Bravo! l'utilisateur integre maitenant la team",201);
        }else{
            return $this->JsonReturn("Unauthorized",403);
        }
    }
}