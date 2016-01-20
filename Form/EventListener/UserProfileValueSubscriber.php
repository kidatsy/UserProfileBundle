<?php

namespace CrisisTextLine\UserProfileBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

class UserProfileValueSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'setData');
    }

    public function setData(FormEvent $event)
    {
        $userProfileValue = $event->getData();
        $form = $event->getForm();

        if (!is_null($userProfileValue)) {
            $this->buildForm($userProfileValue, $form);
        }
    }

    protected function buildForm($userProfileValue, $form)
    {
        $form
            ->add('value', 'text', array(
                'label' => (string) $userProfileValue->getUserProfileField()
            ))
        ;
    }
}