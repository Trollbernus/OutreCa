<?php

namespace Blog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

use Blog\BlogBundle\Entity\Article;

use Blog\BlogBundle\Form\ArticleType;

class BlogController extends Controller
{
    public function blogAction($author, $page)
    {
        if ($page < 1 ) {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($author);
        if (!$user or !$user->hasRole('ROLE_AUTHOR')) {
            throw $this->createNotFoundException('Auteur[auteur='.$author.'] inexistant');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('BlogBlogBundle:Article');
        $query = $repository->createQueryBuilder('a')
            ->where('a.author = :author AND a.published = :published AND a.publicationDate <= CURRENT_DATE()')
            ->setParameters(array('author' => $user->getId(), 'published' => true))
            ->orderBy('a.publicationDate', 'DESC')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, 3);

        return $this->render('BlogBlogBundle:Blog:blog.html.twig', array(
            'pagination' => $pagination,
            'author' => $author
        ));
    }

    public function tableofcontentsAction($author)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($author);
        if (!$user or !$user->hasRole('ROLE_AUTHOR')) {
            throw $this->createNotFoundException('Auteur[auteur='.$author.'] inexistant');
        }

        $repo = $this->getDoctrine()->getManager()->getRepository('BlogBlogBundle:Article');
        $articles = $repo->findBy(array('author' => $user), array('publicationDate' => 'DESC'));

        return $this->render('BlogBlogBundle:Blog:tableofcontents.html.twig', array(
            'articles' => $articles,
            'author' => $author,
            'currentDatetime' => new \Datetime()
        ));
    }

    public function showAction($author, $id, $title)
    {
        if ($title == "") {
            return $this->tableofcontentsAction($author);
        }
        else {
            $repo = $this->getDoctrine()->getManager()->getRepository('BlogBlogBundle:Article');
            $article = $repo->findOneById($id);

            if (!$article) {
                throw $this->createNotFoundException('Article[title='.$title.'] inexistant');
            }
            if ($article->getPublicationDate() > new \Datetime() or !$article->getPublished()) {
                $securityContext = $this->get('security.context');
                if (!$securityContext->isGranted('ROLE_AUTHOR')) {
                    throw $this->createNotFoundException('Article[title='.$title.'] inexistant');
                }
            }
            if ($article->getPublicationDate() > new \Datetime()) {
                $this->get('session')->getFlashBag()->add('info', 'L\'article n\'a pas encore été publié');
                // ne pas afficher l'article si on n'est pas un auteur
            }

            return $this->render('BlogBlogBundle:Blog:show.html.twig', array(
                'article' => $article,
                'author' => $author
            ));
        }
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository('BlogBlogBundle:Article');
        $article = $id ? $repo->findOneById($id) : new Article;
        if (!$article) {
            throw $this->createNotFoundException('Article[id='.$id.'] inexistant');
        }
        $form = $this->createForm(new ArticleType, $article);
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if (!$article->getAuthor()) {
                    $article->setAuthor($this->getUser());
                }
                if (!$article->getPublicationDate()) {
                    $article->setPublicationDate(new \Datetime());
                }

                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('blog_show', array(
                    'author' => $article->getAuthor(),
                    'id' => $article->getId(),
                    'title' => $article->getTitle()
                )));
            }
            else {
                throw $this->createNotFoundException('Formulaire invalide');
            }
        }

        return $this->render('BlogBlogBundle:Blog:edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $article->getId(),
            'publicationDate' => $article->getPublicationDate(),
            'author' => $article->getAuthor()
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('BlogBlogBundle:Article')->findOneById($id);
        $form = $this->createFormBuilder()
            ->add('confirm', 'checkbox', array('label' => 'Confirmer la supression'))
            ->getForm();
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $checkbox = $request->request->get('confirm');
                if ($checkbox != 1) {
                    $em->remove($article);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('info', 'L\'article a bien été supprimé');
                    return $this->redirect($this->generateUrl('blog', array(
                        'author' => $this->getUser(),
                        'page' => 1
                    )));
                }
                else {
                    return $this->redirect($this->generateUrl('blog_show', array(
                        'author' => $this->getUser(),
                        'id' => $article->getId(),
                        'title' => $article->getTitle()
                    )));
                }
            }
        }

        return $this->render('BlogBlogBundle:Blog:delete.html.twig', array(
            'form' => $form->createView(),
            'article' => $article,
            'author' => $this->getUser()
        ));
    }
}
