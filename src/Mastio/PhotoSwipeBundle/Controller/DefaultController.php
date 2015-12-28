<?php

namespace Mastio\PhotoSwipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MastioPhotoSwipeBundle:Default:index.html.twig');
    }
}
