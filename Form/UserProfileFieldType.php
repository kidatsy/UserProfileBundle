<?php

namespace CrisisTextLine\UserProfileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProfileFieldType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('readAccess')
            ->add('writeAccess')
            ->add('type')
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
