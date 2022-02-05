<?php


namespace App\Voter;


use App\Entity\PrivateMessage;
use App\Entity\User;
use App\Repository\BFFRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class PrivateMessageVoter extends Voter
{


    const POST = "POST_PRIVATE_MESSAGE";
    const EDIT = "EDIT_PRIVATE_MESSAGE" ;

    public function __construct(private Security $security,private  BFFRepository $BFFRepository){

    }


    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::POST, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof PrivateMessage) {
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
        if (!$user instanceof  User|| !$subject instanceof PrivateMessage  ){
            return false;
        }
        switch ($attribute) {
            case self::POST:
                return $this->canPost($subject,$user);
            case  self::EDIT:
                return  $this->canEdit($subject,$user);
        }

        throw new \LogicException('This code should not be reached!');

    }

    /**
     * @param PrivateMessage $subject
     * @param User $user
     * @return bool
     */
    private function canPost(PrivateMessage $subject, User $user): bool
    {

        $bff = $this->BFFRepository->findOneBy(["id" => $subject->getId()]);
        if ($bff->getSender() !== $user && $bff -> getReceiver() !== $user || !$bff->getIsAccepted()  ||  !$this->security->isGranted("ROLE_ADMIN"))
        {
            return false;
        }
        return true;

    }

    /**
     * @param PrivateMessage $subject
     * @param User $user
     * @return bool
     */
    private function canEdit(PrivateMessage $subject , User $user): bool
    {
        if ($subject->getWriter() === $user || $this->security->isGranted("ROLE_ADMIN")){
            return true;
        }
        return false;
    }

}