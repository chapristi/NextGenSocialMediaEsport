<?php


namespace App\Voter;



use App\Entity\ChatTeam;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;


final class ChatTeamVoter extends Voter
{

    const EDIT = "EDIT_TEAM_MESSAGE";
    public function __construct(private Security $security, private EntityManagerInterface $entityManager){

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
        //par la suite rajouter la possibilité aux admin de la teamde delete...mais peut etre le faire dans un serializer
        if ($this->security->isGranted('ROLE_ADMIN') || $subject -> getId() === $user -> getId()) {
            return true;
        }
        return false;
    }
}