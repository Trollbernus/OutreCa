<?php

namespace Blog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homepageAction()
    {
        return $this->render('BlogBlogBundle:Default:homepage.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('BlogBlogBundle:Default:about.html.twig');
    }
}
