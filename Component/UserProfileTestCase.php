<?php

namespace CrisisTextLine\UserProfileBundle\Component;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use CrisisTextLine\UserProfileBundle\CrisisTextLineUserProfileBundle;

/**
 * Extend the WebTestCase to add some custom functionality.
 */
abstract class UserProfileTestCase extends BaseWebTestCase
{
    /**
     * A copy of the kernel's container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * A copy of FOS User Bundle's UserManipulator.
     *
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    /**
     * Your User Manipulator service
     */
    protected $userManipulator;

    /**
     * A copy of the EntityManager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * the client
     */
    protected $client;

    /**
     * the user
     */
    protected $user;

    /**
     * Prepare each test
     */
    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();

        $manipulatorService = $this->container->getParameter('crisistextline.user_profile.user_manipulator')['service'];

        $this->userManager = $this->container->get('fos_user.user_manager');
        $this->userManipulator = $this->container->get($manipulatorService);
    }

    /**
     * Get a service.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function get($name)
    {
        return $this->container->get($name);
    }

    protected function logIn($client, $role = null)
    {
        $session = $this->get('session');
        // TC - eventually replace this with search for superadmin w/o specifying account email?
        $email = $this->container->getParameter('crisistextline.user_profile.test_admin_email');
        $this->user = $this->userManager->findUserBy(array('email' => $email));
        $roles = is_null($role) ? $this->user->getRoles() : array($role);
        $firewall = 'main';
        $token = new UsernamePasswordToken($this->user, null, $firewall, $roles);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    protected function p($message)
    {
        fwrite(STDERR, print_r($message . "\n", TRUE));
    }

    public function createOrReturnUser(
        $email,
        $superAdmin = false,
        $password = 'dummyPassword',
        $firstName = 'TestUser',
        $lastName = 'UserProfile',
        $enabled = true
    ) {
        $user = $this->userManager->findUserBy(array('email' => $email));
        if ($user == null) {
            // TODO: figure out how to customize this for each app's own UserManipulator
            $manipulatorMethod = $this->container->getParameter('crisistextline.user_profile.user_manipulator')['method'];
            $user = $this->userManipulator->{$manipulatorMethod}($email, $password, $firstName, $lastName, $enabled, $superAdmin);
        }
        return $user;
    }

    public function findUser($email)
    {
        return $this
            ->get('fos_user.user_manager')
            ->findUserBy(array(
                'email' => $email
            ));
    }
}
