<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    protected $container;
    protected $em;
    protected $repoSection;
    protected $repoField;
    protected $roleNames;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $this->getDoctrine()->getManager();
        $this->repoSection = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileSection');
        $this->repoField = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField');
        $this->roleNames = $container->getParameter('crisistextline.user_profile.roles_names');
    }

    /**
     * Lists all UserProfileField entities.
     *
     * @Route("/", name="user_profile_field")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->repoSection->findAll();

        return array(
            'entities' => $entities,
            'role_names'  => $this->roleNames,
        );
    }

    /**
     * Creates a new UserProfileField entity.
     *
     * @Route("/", name="user_profile_field_create")
     * @Method("POST")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileField:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = $this->generateNewEntity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirect($this->generateUrl('user_profile_field_show', array('id' => $entity->getId())));
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
        $form = $this->createForm(new UserProfileFieldType($this->roleNames), $entity, array(
            'action' => $this->generateUrl('user_profile_field_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UserProfileField entity.
     *
     * @Route("/new", name="user_profile_field_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = $this->generateNewEntity();

        $section = $request->get('section');
        if ($section !== null) {
            $section = $this->repoSection->find($section);
            if ($section !== null) {
                $entity->setSection($section);
            }
        }

        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    private function generateNewEntity()
    {
        $currentHeaviest = intval(
            $this->repoField->getHeaviestWeight()
        );
        return new UserProfileField($currentHeaviest + 1);
    }

    /**
     * Finds and displays a UserProfileField entity.
     *
     * @Route("/{id}", name="user_profile_field_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->repoField->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileField entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'role_names'  => $this->roleNames,
        );
    }

    /**
     * Displays a form to edit an existing UserProfileField entity.
     *
     * @Route("/{id}/edit", name="user_profile_field_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->repoField->find($id);

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
        $form = $this->createForm(new UserProfileFieldType($this->roleNames), $entity, array(
            'action' => $this->generateUrl('user_profile_field_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing UserProfileField entity.
     *
     * @Route("/{id}", name="user_profile_field_update")
     * @Method("PUT")
     * @Template("CrisisTextLineUserProfileBundle:UserProfileField:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->repoField->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProfileField entity.');
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
     * Move a UserProfileField up
     *
     * @Route("/{id}/up", name="user_profile_field_up")
     */
    public function upAction($id, Request $request)
    {
        $entity = $this->repoField->find($id);

        $entity->setWeight($entity->getWeight() - 1);
        $this->em->persist($entity);
        $this->em->flush();

        return $this->redirect($this->getUpDownRedirectPath($request));
    }
    /**
     * Move a UserProfileField down
     *
     * @Route("/{id}/down", name="user_profile_field_down")
     */
    public function downAction($id, Request $request)
    {
        $entity = $this->repoField->find($id);

        $entity->setWeight($entity->getWeight() + 1);
        $this->em->persist($entity);
        $this->em->flush();

        return $this->redirect($this->getUpDownRedirectPath($request));
    }

    private function getUpDownRedirectPath(Request $request)
    {
        $section = $request->get('section');
        return (is_numeric($section))
            ? $this->generateUrl('user_profile_section_show', array('id' => $section))
            : $this->generateUrl('user_profile_field');
    }

    /**
     * Deletes a UserProfileField entity.
     *
     * @Route("/{id}", name="user_profile_field_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = $this->repoField->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserProfileField entity.');
            }

            $this->em->remove($entity);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('user_profile_field'));
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
            ->setAction($this->generateUrl('user_profile_field_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
