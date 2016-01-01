<?php

namespace Mastio\PhotoSwipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('url', 'elfinder', array(
            'instance' => 'form',
            'enable' => true
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mastio\PhotoSwipeBundle\Entity\Image'
        ));
    }

    public function getName()
    {
        return 'mastio_photoswipebundle_imagetype';
    }
}
