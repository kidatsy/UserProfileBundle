<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

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

    /**
     * Finds and displays a UserProfile entity.
     *
     * @Route("/{id}/profile", name="user_profile_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfile')->findByUserId($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfile entity.');
        }

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
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfile')->findByUserId($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfile entity.');
        }

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
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfile')->findByUserId($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfile entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile_edit', array('id' => $entity->getUser()->getId())));
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
        // TC - rename this to be the correct kind of exception.
        return $this->redirect($this->generateUrl('user_profile_delete', array('id' => $id)));
        // return $this->redirect($this->generateUrl('user_profile_show', array('id' => $id)));
    }


    /**
     * Run redirectToAdminOrError()
     *
     * @Route("/{id}/profile/new", name="user_profile_new")
     * @Method("GET")
     */
    public function newAction()
    {
        return $this->redirectToAdminOrError('new');
    }

    /**
     * Run redirectToAdminOrError()
     *
     * @Route("/{id}/profile/create", name="user_profile_create")
     * @Method("POST")
     */
    public function createAction()
    {
        return $this->redirectToAdminOrError('create');
    }

    /**
     * Redirects to Admin UserProfile create URL if got access. Otherwise, return BLAH
     */
    private function redirectToAdminOrError($routeAction)
    {
        // TC - Add in correct level checking here
        return $this->redirect($this->generateUrl('user_profile_admin_' . $routeAction));
    }

}
