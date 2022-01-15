


<?php
/*

namespace App\Voter;


use App\Entity\TeamsEsport;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\The;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TeamsEsportsVoter extends Voter
{

    const EDIT = "EDIT_TEAM";
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
        return $subject -> getId() === $user -> getId();
    }
}
*/