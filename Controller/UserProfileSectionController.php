<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CrisisTextLine\UserProfileBundle\Entity\UserProfileSection;
use CrisisTextLine\UserProfileBundle\Form\UserProfileSectionType;

/**
 * UserProfileSection controller.
 *
 * @Route("/admin/profiles/sections")
 */
class UserProfileSectionController extends Controller
{
    protected $container;
    protected $em;
    protected $repo;
    protected $roleNames;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $this->getDoctrine()->getManager();
        $this->repo = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileSection');
        $this->roleNames = $container->getParameter('crisistextline.user_profile.roles_names');
    }

    /**
     * Creates a new UserProfileSection entity.
     *
     * @Route("/", name="user_profile_section_create")
     * @Method("POST")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileSection:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = $this->generateNewEntity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirect($this->generateUrl('user_profile_section_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a UserProfileSection entity.
     *
     * @param UserProfileSection $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserProfileSection $entity)
    {
        $form = $this->createForm(new UserProfileSectionType($this->roleNames), $entity, array(
            'action' => $this->generateUrl('user_profile_section_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UserProfileSection entity.
     *
     * @Route("/new", name="user_profile_section_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = $this->generateNewEntity();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    private function generateNewEntity()
    {
        $currentHeaviest = intval(
            $this->repo->getHeaviestWeight()
        );
        return new UserProfileSection($currentHeaviest + 1);
    }

    /**
     * Finds and displays a UserProfileSection entity.
     *
     * @Route("/{id}", name="user_profile_section_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->repo->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileSection entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'role_names'  => $this->roleNames,
        );
    }

    /**
     * Displays a form to edit an existing UserProfileSection entity.
     *
     * @Route("/{id}/edit", name="user_profile_section_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->repo->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileSection entity.');
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
    * Creates a form to edit a UserProfileSection entity.
    *
    * @param UserProfileSection $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UserProfileSection $entity)
    {
        $form = $this->createForm(new UserProfileSectionType($this->roleNames), $entity, array(
            'action' => $this->generateUrl('user_profile_section_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Move a UserProfileSection up
     *
     * @Route("/{id}/up", name="user_profile_section_up")
     */
    public function upAction($id)
    {
        $entity = $this->repo->find($id);

        $entity->setWeight($entity->getWeight() - 1);
        $this->em->persist($entity);
        $this->em->flush();

        return $this->redirect($this->generateUrl('user_profile_field'));
    }
    /**
     * Move a UserProfileSection down
     *
     * @Route("/{id}/down", name="user_profile_section_down")
     */
    public function downAction($id)
    {
        $entity = $this->repo->find($id);

        $entity->setWeight($entity->getWeight() + 1);
        $this->em->persist($entity);
        $this->em->flush();

        return $this->redirect($this->generateUrl('user_profile_field'));
    }

    /**
     * Edits an existing UserProfileSection entity.
     *
     * @Route("/{id}", name="user_profile_section_update")
     * @Method("PUT")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileSection:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->repo->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileSection entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->em->flush();

            return $this->redirect($this->generateUrl('user_profile_field'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UserProfileSection entity.
     *
     * @Route("/{id}", name="user_profile_section_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = $this->repo->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserProfileSection entity.');
            }

            $this->em->remove($entity);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('user_profile_field'));
    }

    /**
     * Creates a form to delete a UserProfileSection entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_profile_section_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
