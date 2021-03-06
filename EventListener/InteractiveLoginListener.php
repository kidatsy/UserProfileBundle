<?php

namespace CrisisTextLine\UserProfileBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManager;

use CrisisTextLine\UserProfileBundle\Entity\UserProfile;
use CrisisTextLine\UserProfileBundle\Service\UserProfileManager;

/**
 * service_id: crisistextline.event_listener.create_profile_on_login
 */
class InteractiveLoginListener
{
    protected $em;

    protected $userProfileManager;

    public function __construct (
        EntityManager $em,
        UserProfileManager $userProfileManager
    ) {
        $this->em = $em;
        $this->userProfileManager = $userProfileManager;
    }

    public function createProfileOnLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $user = $token->getUser();

        $userProfile = $this->userProfileManager->createUserProfileIfMissing($user);
    }

}
