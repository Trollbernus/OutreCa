<?php
namespace Blog\BlogBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Knp\Menu\FactoryInterface;

class MenuBuilder extends ContainerAware
{
    public function menu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array('navbar' => true));
        $menu->addChild('menu.home', array('icon' => 'home', 'route' => 'homepage'));
        $menu->addChild('menu.about', array('icon' => 'info-sign', 'route' => 'about'));

        $securityContext = $this->container->get('security.context');

        if (!$securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $menu->addChild('layout.login', array('icon' => 'user', 'route' => 'fos_user_security_login'))
                     ->setExtra('translation_domain', 'FOSUserBundle')
                     ->setAttribute('class', 'pull-right');
            $menu->addChild('layout.register', array('icon' => 'pencil', 'route' => 'fos_user_registration_register'))
                     ->setExtra('translation_domain', 'FOSUserBundle')
                     ->setAttribute('class', 'pull-right');
        }
        else {
            $username = $securityContext->getToken()->getUsername();
            $dropdown = $menu->addChild($username, array('dropdown' => true, 'caret' => true))
                                 ->setExtra('trans', false)
                                 ->setAttribute('class', 'pull-right');

            $dropdown->addChild('menu.my_account', array('route' => 'fos_user_profile_edit'));

            if ($securityContext->isGranted('ROLE_ADMIN')) {
                // $dropdown->addChild('divider_1', array('divider' => true));
            }

            if ($securityContext->isGranted('ROLE_AUTHOR')) {
                $dropdown->addChild('divider_2', array('divider' => true));

                $dropdown->addChild('menu.new_article', array('route' => 'blog_create'));
                $dropdown->addChild('menu.my_articles', array('route' => 'blog_show', 'routeParameters' => array('author' => $username)));
            }

            $dropdown->addChild('divider_end', array('divider' => true));
            $dropdown->addChild('layout.logout', array('route' => 'fos_user_security_logout'))
                     ->setExtra('translation_domain', 'FOSUserBundle');
        }

        return $menu;
    }

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $mainmenu = $factory->createItem('root', array('navbar' => true));
        $mainmenu->addChild('menu.home', array('icon' => 'home', 'route' => 'homepage'));
        $mainmenu->addChild('menu.about', array('icon' => 'info-sign', 'route' => 'about'));

        return $mainmenu;
    }

    public function userMenu(FactoryInterface $factory, array $options) {
        $securityContext = $this->container->get('security.context');

        $usermenu = $factory->createItem('root', array('navbar' => true, 'pull-right' => true));

        if (!$securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usermenu->addChild('layout.login', array('icon' => 'user', 'route' => 'fos_user_security_login'))
                     ->setExtra('translation_domain', 'FOSUserBundle');
            $usermenu->addChild('layout.register', array('icon' => 'pencil', 'route' => 'fos_user_registration_register'))
                     ->setExtra('translation_domain', 'FOSUserBundle');
        }
        else {
            $username = $securityContext->getToken()->getUsername();
            $dropdown = $usermenu->addChild($username, array('dropdown' => true, 'caret' => true))
                                 ->setExtra('trans', false);

            $dropdown->addChild('menu.my_account', array('route' => 'fos_user_profile_edit'));

            if ($securityContext->isGranted('ROLE_ADMIN')) {
                // $dropdown->addChild('divider_1', array('divider' => true));
            }

            if ($securityContext->isGranted('ROLE_AUTHOR')) {
                $dropdown->addChild('divider_2', array('divider' => true));

                $dropdown->addChild('menu.new_article', array('route' => 'blog_create'));
                $dropdown->addChild('menu.my_articles', array('route' => 'blog_show', 'routeParameters' => array('author' => $username)));
            }

            $dropdown->addChild('divider_end', array('divider' => true));
            $dropdown->addChild('layout.logout', array('route' => 'fos_user_security_logout'))
                     ->setExtra('translation_domain', 'FOSUserBundle');
        }

        return $usermenu;
    }
}
