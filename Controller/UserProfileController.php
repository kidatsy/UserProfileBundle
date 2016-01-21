<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CrisisTextLine\UserProfileBundle\Model\UserProfileUserInterface;
use CrisisTextLine\UserProfileBundle\Entity\UserProfile;
use CrisisTextLine\UserProfileBundle\Form\UserProfileType;

/**
 * UserProfile controller.
 *
 * @Route("/user")
 */
class UserProfileController extends Controller
{
    protected $container;
    protected $em;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $this->getDoctrine()->getManager();
    }

    /**
     * Finds and displays a UserProfile entity.
     *
     * @Route("/{id}/profile", name="user_profile_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->getOrCreateUserProfile($id);

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing UserProfile entity.
     *
     * @Route("/{id}/profile/edit", name="user_profile_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->getOrCreateUserProfile($id);
        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing UserProfile entity.
     *
     * @Route("/{id}/profile", name="user_profile_update")
     * @Method("PUT")
     * @Template("CrisisTextLineUserProfileBundle:UserProfile:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getOrCreateUserProfile($id);

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->em->flush();

            return $this->redirect($this->generateUrl('user_profile_show', array('id' => $entity->getUser()->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a UserProfile entity.
    *
    * @param UserProfile $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UserProfile $entity)
    {
        $form = $this->createForm(new UserProfileType(), $entity, array(
            'action' => $this->generateUrl('user_profile_update', array('id' => $entity->getUser()->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
    * Gets or creates user profile, given user's ID
    *
    * @param integer $id ID
    *
    * @return UserProfile $profile
    */
    private function getOrCreateUserProfile($id)
    {
        $profile = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfile')->findByUserId($id);
        $profileManager = $this->get('crisistextline.user_profile_manager');

        if ($profile) {
            $profile = $profileManager->attachMissingUserProfileValues($profile);
        } else {
            $user = $this->get('fos_user.user_manager')->findUserBy(array('id' => $id));
            $profile = $profileManager->createUserProfile($user);
        }

        return $profile;
    }

    /**
     * Does not delete a UserProfile entity.
     *
     * @Route("/{id}/profile", name="user_profile_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        // TC - rename this to be the correct kind of exception.
        throw $this->createNotFoundException('Sorry, not able to delete profiles once they are created.');
    }

    /**
     * Does not delete, redirects back to profile show.
     *
     * @Route("/{id}/profile/delete", name="user_profile_delete_redirect")
     * @Method("GET")
     */
    public function deleteRedirectAction($id)
    {
        return $this->redirect($this->generateUrl('user_profile_delete', array('id' => $id)));
    }


    /**
     * Run redirectToAdminOrError()
     *
     * @Route("/{id}/profile/new", name="user_profile_new")
     * @Method("GET")
     */
    public function newAction()
    {
        return $this->redirectToAdminOrException('new');
    }

    /**
     * Run redirectToAdminOrError()
     *
     * @Route("/{id}/profile/create", name="user_profile_create")
     * @Method("POST")
     */
    public function createAction()
    {
        return $this->redirectToAdminOrException('create');
    }

    /**
     * Redirects to Admin UserProfile create URL if got access. Otherwise, return BLAH
     */
    private function redirectToAdminOrException($routeAction)
    {
        // TC - Add in correct level checking here
        return $this->redirect($this->generateUrl('user_profile_admin_' . $routeAction));
    }

}
