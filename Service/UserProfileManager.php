<?php

namespace CrisisTextLine\UserProfileBundle\Service;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

// use CrisisTextLine\UserProfileBundle\Entity\UserProfileUserInterface as User;
use CrisisTextLine\UserProfileBundle\Entity\UserProfile;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileValue;

/**
 * service_id: crisistextline.service.user_profile_manager
 */
class UserProfileManager
{
    /**
     * The entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * The UserProfile repo.
     * @var \CrisisTextLine\UserProfileBundle\Entity\Repository\UserProfileRepository
     */
    protected $repo;

    /**
     * The FOS User Manager
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    /**
     * The Role Hierarchy maker
     * @var \Symfony\Component\Security\Core\Role\RoleHierarchy
     */
    protected $roleHierarchy;

    /**
     * Constructor.
     */
    public function __construct (
        EntityManager $em,
        UserManager $userManager,
        RoleHierarchy $roleHierarchy
    ) {
        $this->em = $em;
        $this->repo = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfile');
        $this->userManager = $userManager;
        $this->roleHierarchy = $roleHierarchy;
    }

    /**
    * Gets or creates user profile, given user's ID
    *
    * @param integer $id ID
    *
    * @return UserProfile $profile
    */
    public function findOrCreateByUserID($id)
    {
        $profile = $this->repo->findByUserId($id);

        if ($profile) {
            $profile = $this->attachMissingUserProfileValues($profile);
        } else {
            $user = $this->userManager->findUserBy(array('id' => $id));
            $profile = $this->createUserProfileIfMissing($user);
        }

        return $profile;
    }

    public function createUserProfileIfMissing($user)
    {
        if (!isset($user)) {
            throw new \Exception('User (so therefore Profile) does not exist.');
        }
        $userProfile = $user->getUserProfile();
        if ($userProfile == null) {
            $userProfile = new UserProfile();
            $userProfile->setUser($user);
            $user->setUserProfile($userProfile);
            $this->em->persist($userProfile);
            $this->em->persist($user);
            $this->em->flush();
        }

        $userProfile = $this->attachMissingUserProfileValues($userProfile);

        return $userProfile;
    }

    /**
     * Blah
     *
     */
    public function attachMissingUserProfileValues(UserProfile $userProfile)
    {
        $fields = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField')
            ->findAll();

        foreach ($fields as $field) {
            if ($userProfile->hasValueForField($field) == false) {
                $default = $field->getDefaultValue();
                $value = new UserProfileValue($userProfile, $field, $default);
                $userProfile->addValue($value);
                $this->em->persist($userProfile);
                $this->em->persist($value);
            }
        }
        $this->em->flush();

        return $userProfile;
    }

    /**
    * Returns whether or not User should have access to write or edit a profile Field
    * This looks only at the field object itself, not any particular profile's fields
    *
    * @param string $action
    * @param UserProfileField $field
    * @param User $user
    *
    * @return boolean
    */
    public function checkFieldAccess($action, $field, $user)
    {
        $userRoles = $this->getUserRolesArray($user);
        $desiredRoleName = null;

        switch ($action) {
            case 'write':
                if (($writeAccess = $field->getWriteAccess()) !== null) {
                    $desiredRoleName = $writeAccess;
                }
                // Note: not breaking intentionally here, to get the cascade
            case 'read':
                if ( $desiredRoleName == null && (($readAccess = $field->getReadAccess()) !== null) ) {
                    $desiredRoleName = $readAccess;
                }
        }

        if ( $desiredRoleName == null && (($sectionAccess = $field->getSection()->getAccessLevel()) !== null) ) {
            $desiredRoleName = $sectionAccess;
        }

        if ($desiredRoleName !== null) {
            $desiredRole = new Role($desiredRoleName);
            return in_array($desiredRole, $userRoles);
        } else {
            return true;
        }
    }

    private function getUserRolesArray($user)
    {
        $userRoles = $user->getRoles();
        array_walk($userRoles, function (&$value, $idx) {
            $value = new Role($value);
        });

        return $this->roleHierarchy->getReachableRoles($userRoles);
    }
}
