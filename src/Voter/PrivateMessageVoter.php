<?php
// src/Security/PostVoter.php
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

    public function __construct
    (
        private BFFRepository $BFFRepository,
        private Security $security,
    )
    {}

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::POST, self::EDIT])) {
            return false;
        }
        if (!$subject instanceof PrivateMessage) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {

            return false;
        }
        switch ($attribute) {
            case self::POST:
                return $this->canPost($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canPost(PrivateMessage $subject, User $user): bool
    {
        $bff = $this->BFFRepository->findOneBy(["token" => $subject->getBff()->getToken()]);
        if ($bff->getSender() === $user || $bff -> getReceiver() === $user && $bff->getIsAccepted() === true ||  $this->security->isGranted("ROLE_ADMIN"))
        {
            return true;
        }
        return false;
    }

    private function canEdit(PrivateMessage $subject, User $user): bool
    {
        if ($subject->getWriter() === $user || $this->security->isGranted("ROLE_ADMIN")){
            return true;
        }
        return false;
    }
}