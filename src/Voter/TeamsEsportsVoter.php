<?php


namespace App\Voter;


use App\Entity\TeamsEsport;
use App\Entity\User;
use App\Entity\UserJoinTeam;
use App\Repository\UserJoinTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class TeamsEsportsVoter extends Voter
{

    const EDIT = "EDIT_TEAM";
    public function __construct(private Security $security, private EntityManagerInterface $entityManager,private UserJoinTeamRepository $joinTeamRepository){

    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::EDIT && $subject instanceof  TeamsEsport;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        $ujt = $this->joinTeamRepository->findByExampleField($user,$subject);
        if (!$user instanceof  User || !$subject instanceof TeamsEsport  ){
            return false;
        }
        if (!empty($ujt[0]->getRole()[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" || $this->security->isGranted('ROLE_ADMIN')  ) {

            return true;
        }
        return false;
    }
}
