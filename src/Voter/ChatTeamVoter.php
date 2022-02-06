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
    const POST = "POST_TEAM_MESSAGE";

    public function __construct(private Security $security, private EntityManagerInterface $entityManager,private UserJoinTeamRepository $joinTeamRepository){

    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT,self::POST])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof ChatTeam) {
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
        if (!$user instanceof  User || !$subject instanceof ChatTeam){
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($subject,$user);
            case self::EDIT:
                return $this->canEdit($subject,$user);
            case self::POST:
                return $this->canPost($subject,$user);

        }

        throw new \LogicException('This code should not be reached!');

    }

    /**
     * @param ChatTeam $subject
     * @param User $user
     * @return bool
     */
    private  function canEdit(ChatTeam $subject, User $user)
    {
        if ($this->security->isGranted('ROLE_ADMIN') || $subject -> getId() === $user -> getId()) {

            return true;
        }
        return false;
    }

    /**
     * @param ChatTeam $subject
     * @param User $user
     * @return bool
     */
    private function canDelete(ChatTeam $subject, User $user)
    {
        $ujt = $this->joinTeamRepository->findByExampleField(
            $this->security->getUser(),
            $subject -> getTeam()
        );
        if (!$ujt ){
            return false;
        }


        if ($this->security->isGranted('ROLE_ADMIN') || $subject -> getId() === $user -> getId() || !empty($ujt[0]) && $ujt[0]->getRole()[0] === "ROLE_ADMIN") {

            return true;
        }

        return false;
    }
    private function canPost(ChatTeam $subject, User $user){
        $ujt = $this->joinTeamRepository->findByExampleField(
            $this->security->getUser(),
            $subject -> getTeam()
        );
        if (!$ujt || $ujt->getIsValidated() !== true){
            return false;
        }
        return true;
    }
}