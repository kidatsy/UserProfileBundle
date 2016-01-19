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
     * @Route("/", name="user_profile_admin")
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

    /**
     * Displays a form to create a new UserProfile entity.
     *
     * @Route("/new", name="user_profile_admin_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UserProfile();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new UserProfile entity.
     *
     * @Route("/", name="user_profile_admin_create")
     * @Method("POST")
     * @Template("CrisisTextLineUserProfileBundle:UserProfile:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new UserProfile();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile_show', array('id' => $entity->getUser()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a UserProfile entity.
     *
     * @param UserProfile $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserProfile $entity)
    {
        $form = $this->createForm(new UserProfileType(), $entity, array(
            'action' => $this->generateUrl('user_profile_admin_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}
