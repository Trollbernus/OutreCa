<?php

namespace Mastio\PhotoSwipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('images', 'collection', array(
            'type' => new ImageType(),
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'widget_add_btn' => array('label' => "add image"),
            'show_legend' => false,
            'options' => array(
                'label_render' => false,
                'widget_addon_prepend' => array(
                    'text' => '@',
                ),
                'horizontal_input_wrapper_class' => "col-lg-8",
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mastio\PhotoSwipeBundle\Entity\Gallery'
        ));
    }

    public function getName()
    {
        return 'mastio_photoswipebundle_gallerytype';
    }
}
