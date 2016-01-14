<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileValue;
use CrisisTextLine\UserProfileBundle\Form\UserProfileValueType;

/**
 * UserProfileValue controller.
 *
 * @Route("/user/profiles/value")
 */
class UserProfileValueController extends Controller
{

    /**
     * Lists all UserProfileValue entities.
     *
     * @Route("/", name="user_profiles_value")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileValue')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new UserProfileValue entity.
     *
     * @Route("/", name="user_profiles_value_create")
     * @Method("POST")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileValue:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new UserProfileValue();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_profiles_value_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a UserProfileValue entity.
     *
     * @param UserProfileValue $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserProfileValue $entity)
    {
        $form = $this->createForm(new UserProfileValueType(), $entity, array(
            'action' => $this->generateUrl('user_profiles_value_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UserProfileValue entity.
     *
     * @Route("/new", name="user_profiles_value_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UserProfileValue();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a UserProfileValue entity.
     *
     * @Route("/{id}", name="user_profiles_value_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileValue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UserProfileValue entity.
     *
     * @Route("/{id}/edit", name="user_profiles_value_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileValue entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a UserProfileValue entity.
    *
    * @param UserProfileValue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UserProfileValue $entity)
    {
        $form = $this->createForm(new UserProfileValueType(), $entity, array(
            'action' => $this->generateUrl('user_profiles_value_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing UserProfileValue entity.
     *
     * @Route("/{id}", name="user_profiles_value_update")
     * @Method("PUT")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileValue:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileValue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_profiles_value_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a UserProfileValue entity.
     *
     * @Route("/{id}", name="user_profiles_value_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileValue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserProfileValue entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_profiles_value'));
    }

    /**
     * Creates a form to delete a UserProfileValue entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_profiles_value_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
