<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileField;
use CrisisTextLine\UserProfileBundle\Form\UserProfileFieldType;

/**
 * UserProfileField controller.
 *
 * @Route("/admin/profiles/fields")
 */
class UserProfileFieldController extends Controller
{

    /**
     * Lists all UserProfileField entities.
     *
     * @Route("/", name="admin_profiles_field")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new UserProfileField entity.
     *
     * @Route("/", name="admin_profiles_field_create")
     * @Method("POST")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileField:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new UserProfileField();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_profiles_field_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a UserProfileField entity.
     *
     * @param UserProfileField $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserProfileField $entity)
    {
        $form = $this->createForm(new UserProfileFieldType(), $entity, array(
            'action' => $this->generateUrl('admin_profiles_field_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UserProfileField entity.
     *
     * @Route("/new", name="admin_profiles_field_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UserProfileField();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a UserProfileField entity.
     *
     * @Route("/{id}", name="admin_profiles_field_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileField entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UserProfileField entity.
     *
     * @Route("/{id}/edit", name="admin_profiles_field_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileField entity.');
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
    * Creates a form to edit a UserProfileField entity.
    *
    * @param UserProfileField $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UserProfileField $entity)
    {
        $form = $this->createForm(new UserProfileFieldType(), $entity, array(
            'action' => $this->generateUrl('admin_profiles_field_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing UserProfileField entity.
     *
     * @Route("/{id}", name="admin_profiles_field_update")
     * @Method("PUT")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileField:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileField entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_profiles_field_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a UserProfileField entity.
     *
     * @Route("/{id}", name="admin_profiles_field_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserProfileField entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_profiles_field'));
    }

    /**
     * Creates a form to delete a UserProfileField entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_profiles_field_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
