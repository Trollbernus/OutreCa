<?php

namespace Blog\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
            'horizontal' => false,
            'label_render' => false,
            'attr' => array(
                'placeholder' => 'Titre'
            )
        ));

        $builder->add('content', 'ckeditor', array(
            'horizontal' => false,
            'label_render' => false,
            'attr' => array(
                'rows'  => 10
            ),
            'height' => 500
        ));

        $builder->add('publicationDate', 'datetime', array(
            'label' => 'Date de publication',
            'horizontal_label_class' => 'col-sm-3 col-lg-offset-6',
            'horizontal_input_wrapper_class' => 'col-lg-3',
            'widget' => 'single_text',
            'widget_reset_icon' => true,
            'datetimepicker' => array(
                'attr' => array('data-start-view' => 2)
            ),
            'attr' => array(
                'placeholder' => 'Maintenant'
            ),
            'required' => false
        ));

        $builder->add('published', 'checkbox', array(
            'horizontal_label_class' => 'col-sm-3 col-lg-offset-6',
            'horizontal_input_wrapper_class' => 'col-lg-3',
            'label' => 'Publié',
            'required' => false
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blog\BlogBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'blog_blogbundle_articletype';
    }
}
