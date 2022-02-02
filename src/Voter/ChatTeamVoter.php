<?php


namespace App\Voter;

use App\Entity\ChatTeam;
use App\Entity\User;
use App\Entity\UserJoinTeam;
use App\Repository\UserJoinTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;


final class ChatTeamVoter extends Voter
{

    const EDIT = "EDIT_TEAM_MESSAGE";
    const DELETE = "DELETE_TEAM_MESSAGE";
    public function __construct(private Security $security, private EntityManagerInterface $entityManager,private UserJoinTeamRepository $joinTeamRepository){

    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::EDIT && $subject instanceof  ChatTeam;
    }
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof  User || !$subject instanceof ChatTeam){
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($subject,$user);
            case self::EDIT:
                return $this->canEdit($subject,$user);
        }

        throw new \LogicException('This code should not be reached!');

    }
    private  function canEdit(ChatTeam $subject,User $user)
    {
        if ($this->security->isGranted('ROLE_ADMIN') || $subject -> getId() === $user -> getId()) {

            return true;
        }
        return false;
    }
    private function canDelete(ChatTeam $subject,User $user)
    {
        $ujt = $this->joinTeamRepository->findByExampleField(
            $this->security->getUser(),
            $subject -> getTeam()
        );
        if (!$ujt){
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN') || $subject -> getId() === $user -> getId() || !empty($ujt[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN") {

            return true;
        }
        return false;
    }
}