<?php

namespace CrisisTextLine\UserProfileBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManager;

use CrisisTextLine\UserProfileBundle\Entity\UserProfile;

class InteractiveLoginListener
{
    protected $em;

    public function __construct (
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function createProfileOnLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $user = $token->getUser();

        // If the user is not flagged for 2FA, skip all this stuff
        if ($user->getUserProfile() == null) {
            $userProfile = new UserProfile($user);
            $this->em->persist($userProfile);
            $this->em->flush($userProfile);
        }
    }

}
