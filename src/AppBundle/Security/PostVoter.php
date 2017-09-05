<?php


namespace AppBundle\Security;


use AppBundle\Entity\BlogPost;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PostVoter extends Voter
{
    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof BlogPost){
            return false;
        }

        if (in_array($attribute, ['edit', 'delete'])) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($subject->getAuthor() !== $user) {
            return false;
        }

        return true;
    }

}