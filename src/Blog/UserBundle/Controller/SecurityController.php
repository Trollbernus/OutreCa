<?php

namespace Blog\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Blog\UserBundle\Form\LoginType;

class SecurityController extends BaseController
{
    protected function renderLogin(array $data)
    {
        $form = $this->container->get('form.factory')
            ->create(new LoginType, array('_username' => $data['last_username']), array(
                'action' => $this->container->get('router')->generate('fos_user_security_check'),
                'method' => 'POST'
            ));
        $data['form'] = $form->createView();

        return $this->render('BlogUserBundle:Security:login.html.twig', $data);
    }
}
