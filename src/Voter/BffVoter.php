<?php


namespace App\Voter;


use App\Entity\BFF;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class BffVoter extends Voter
{
    const DELETE = "DELETE_BFF";

    public function __construct(private Security $security){

    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE && $subject instanceof BFF;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof  User || !$subject instanceof BFF){
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN') || $subject -> getSender() === $user || $subject -> getReceiver() === $user ) {
            return true;
        }
        return false;
    }
}