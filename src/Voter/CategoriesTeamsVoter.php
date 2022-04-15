<?php


namespace App\Voter;


use App\Entity\CatgeoriesTeamsEsport;
use App\Entity\User;
use App\Repository\UserJoinTeamRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class CategoriesTeamsVoter extends Voter
{
    const POST = "POST_CATEGORIES_TEAMS";
    const DELETE = "DELETE_CATEGORIES_TEAMS";

    public function __construct(private Security $security, private UserJoinTeamRepository $joinTeamRepository){

    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::POST, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof CatgeoriesTeamsEsport) {
            return false;
        }

        return true;

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
        if (!$user instanceof  User || !$subject instanceof CatgeoriesTeamsEsport  ){
            return false;
        }
        switch ($attribute) {
            case self::POST:
                return $this->canPost($subject,$user);
            case  self::DELETE:
                return  $this->canDelete($subject,$user);
        }

        throw new \LogicException('This code should not be reached!');

    }

    /**
     * @param CatgeoriesTeamsEsport $subject
     * @param User $user
     * @return bool
     */
    private function canPost(CatgeoriesTeamsEsport $subject, User $user): bool
    {
        $ujt = $this->joinTeamRepository->findByExampleField($user,$subject->getTeamEsport());
        if (!empty($ujt[0]->getRole()[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" || $this->security->isGranted('ROLE_ADMIN')  ) {
            return true;
        }
        return false;
    }

    /**
     * @param CatgeoriesTeamsEsport $subject
     * @param User $user
     * @return bool
     */
    private function canDelete(CatgeoriesTeamsEsport $subject , User $user): bool
    {
        $ujt = $this->joinTeamRepository->findByExampleField($user,$subject->getTeamEsport());
        if (!empty($ujt[0]->getRole()[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" || $this->security->isGranted('ROLE_ADMIN')  ) {
            return true;
        }
        return false;
    }



}