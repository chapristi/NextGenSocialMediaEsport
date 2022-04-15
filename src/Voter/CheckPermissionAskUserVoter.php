<?php


namespace App\Voter;


use App\Entity\AskUserJoinTeam;
use App\Entity\User;
use App\Repository\UserJoinTeamRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class CheckPermissionAskUserVoter extends Voter
{
    const POST = "POST_ASK_USER_JOIN_TEAM";
    const DELETE = "DELETE_ASK_USER_JOIN_TEAM";

    public function __construct(private Security $security, private UserJoinTeamRepository $joinTeamRepository){

    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::POST, self::DELETE])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof AskUserJoinTeam) {
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
        if (!$user instanceof  User || !$subject instanceof AskUserJoinTeam  ){
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
     * @param AskUserJoinTeam $subject
     * @param User $user
     * @return bool
     */
    private function canPost(AskUserJoinTeam $subject, User $user): bool
    {
        $ujt = $this->joinTeamRepository->findByExampleField($user,$subject->getTeams());
        if (!empty($ujt[0]->getRole()[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" || $this->security->isGranted('ROLE_ADMIN')  ) {
            return true;
        }
        return false;
    }

    /**
     * @param AskUserJoinTeam $subject
     * @param User $user
     * @return bool
     */
    private function canDelete(AskUserJoinTeam $subject , User $user): bool
    {
        if ( $user === $subject->getUserAsked() ||$this->security->isGranted('ROLE_ADMIN') || $user === $subject->getUsers()){
            return true ;
        }
        return false;
    }



}