<?php

namespace App\Controller;


use App\Entity\UserJoinTeam;
use App\Repository\AskUserJoinTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;


class AcceptToJoinTeamController extends AbstractController
{
    public function __construct
    (
        private AskUserJoinTeamRepository $askUserJoinTeam,
        private EntityManagerInterface $entityManager,
        private Security $security

    )
    {}

    /**
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    private function JsonReturn(string $message, int $code):JsonResponse
    {
        return $this->json([
            "infos" => $message,
            "code" => $code
        ],$code);
    }

    /**
     * @param string $token
     */
    public function __invoke(string $token):JsonResponse
    {
        $join = $this->askUserJoinTeam->findOneBy([
            "token" => $token
        ]);
        if ($join->getUserAsked() !== $this->security->getUser())
        {
            return $this->JsonReturn("you don't have necessary rights to do this!!",403);
        }

        $this->entityManager->remove($join);

        $ujt = (new UserJoinTeam())
            ->addUser($this->security->getUser())
            ->addTeam($join->getTeams())
            ->setIsValidated(true)

        ;
        $this->entityManager->remove($join);
        $this->entityManager->persist($ujt);
        $this->entityManager->flush();
        return $this->JsonReturn("good you joined the team ;)",403);
    }
}
