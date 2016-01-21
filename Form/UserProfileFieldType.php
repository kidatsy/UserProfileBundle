<?php

namespace CrisisTextLine\UserProfileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use CrisisTextLine\UserProfileBundle\CrisisTextLineUserProfileBundle as Bundle;

class UserProfileFieldType extends AbstractType
{
    private $roleNames;

    public function __construct($roleNames)
    {
        $this->roleNames = $roleNames;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('defaultValue')
            ->add('section', null, array(
                'required' => true
            ))
            ->add('type', 'choice', array(
                'choices' => Bundle::getHumanReadableFieldTypes(),
                'required' => true
            ))
            ->add('readAccess', 'choice', array(
                'choices' => $this->roleNames,
                'required' => false
            ))
            ->add('writeAccess', 'choice', array(
                'choices' => $this->roleNames,
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CrisisTextLine\UserProfileBundle\Entity\UserProfileField'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crisistextline_userprofilebundle_userprofilefield';
    }
}
