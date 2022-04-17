<?php


namespace App\Voter;


use App\Entity\CatgeoriesUser;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class CatgoriesUserVoter extends Voter
{
    const  DELETE = "DELETE_CATEGORIES_USER";

    public function __construct(private Security $security){

    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE  && $subject instanceof  CatgeoriesUser;
    }


    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof  User || !$subject instanceof CatgeoriesUser){
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN') || $subject->getUser() === $user) {
            return true;
        }
        return false;
    }
}