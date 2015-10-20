<?php

namespace Blog\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username', 'text', array(
            'label' => 'security.login.username',
            'attr' => array('placeholder' => 'profile.show.username'),
            'widget_type' => "inline",
            'translation_domain' => 'FOSUserBundle'
        ));

        $builder->add('_password', 'password', array(
            'label' => 'security.login.password',
            'widget_type' => "inline",
            'translation_domain' => 'FOSUserBundle'
        ));

        $builder->add('_remember_me', 'checkbox', array(
            'label' => 'security.login.remember_me',
            'attr' => array('checked' => 'checked'),
            'translation_domain' => 'FOSUserBundle'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_token',
            'intention' => 'authenticate'
        ));
    }


    public function getName()
    {
        return '';
    }
}
