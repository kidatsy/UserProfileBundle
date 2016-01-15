<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CrisisTextLine\UserProfileBundle\Entity\UserProfile;

/**
 * UserProfile controller.
 *
 * @Route("/admin/profiles")
 */
class UserProfileAdminController extends Controller
{

    /**
     * Lists all UserProfile entities.
     *
     * @Route("/", name="user_profile")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfile')->findAll();

        return array(
            'entities' => $entities,
        );
    }
}
