<?php


namespace App\Voter;


use App\Entity\TeamsEsport;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class TeamsEsportsVoter extends Voter
{

    const EDIT = "EDIT_TEAM";
    public function __construct(private Security $security){

    }
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::EDIT && $subject instanceof  TeamsEsport;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof  User || !$subject instanceof TeamsEsport){
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        return false;
    }
}
