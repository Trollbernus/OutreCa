<?php

namespace Blog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mastio\PhotoSwipeBundle\Entity\Gallery;

use Mastio\PhotoSwipeBundle\Form\GalleryType;

class GalleryController extends Controller
{
    public function displayAction($id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MastioPhotoSwipeBundle:Gallery');

        if ($id == 0) {
            $galleries = $repo->findBy(array(), array('id' => 'DESC'));

            return $this->render('BlogBlogBundle:Gallery:view.html.twig', array(
                'galleries' => $galleries
            ));
        }
        else {
            $gallery = $repo->findOneById($id);
            if (!$gallery) {
                throw $this->createNotFoundException('Galerie[id='.$id.'] inexistant');
            }

            return $this->render('BlogBlogBundle:Gallery:display.html.twig', array(
                'images' => $gallery->getImages(),
                'id' => $gallery->getId()
            ));
        }
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository('MastioPhotoSwipeBundle:Gallery');
        $gallery = $id ? $repo->findOneById($id) : new Gallery;
        if (!$gallery) {
            throw $this->createNotFoundException('Galerie[id='.$id.'] inexistant');
        }
        $form = $this->createForm(new GalleryType, $gallery);
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $images = $gallery->getImages();
            foreach ($images as $image) {
                $image->setGallery();
            }
            $form->handleRequest($request);

            if ($form->isValid()) {
                $images = $gallery->getImages();
                foreach ($images as $image) {
                    $image->setGallery($gallery);

                    $_img_size = getimagesize(__DIR__ . '/../../../../web'.$image->getUrl());
                    $image->setWidth($_img_size[0]);
                    $image->setHeight($_img_size[1]);

                    $em->persist($image);
                }
                $em->persist($gallery);

                $images_to_remove = $this->getDoctrine()->getRepository('MastioPhotoSwipeBundle:Image')
                             ->findByGallery(NULL);
                foreach ($images_to_remove as $image) {
                    $em->remove($image);
                }

                $em->flush();

                return $this->redirect($this->generateUrl('gallery_display', array(
                    'id' => $gallery->getId()
                )));
            }
            else {
                throw $this->createNotFoundException('Formulaire invalide');
            }
        }

        return $this->render('BlogBlogBundle:Gallery:edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $gallery->getId()
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = $em->getRepository('MastioPhotoSwipeBundle:Gallery')->findOneById($id);
        $form = $this->createFormBuilder()
            ->add('confirm', 'checkbox', array('label' => 'Confirmer la supression'))
            ->getForm();
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $checkbox = $request->request->get('confirm');
                if ($checkbox != 1) {
                    $images = $gallery->getImages();
                    foreach ($images as $image) {
                        $em->remove($image);
                    }
                    $em->remove($gallery);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('info', 'La galerie a bien été supprimée');
                    return $this->redirect($this->generateUrl('gallery_create'));
                }
                else {
                    return $this->redirect($this->generateUrl('gallery_display', array(
                        'id' => $gallery->getId()
                    )));
                }
            }
        }

        return $this->render('BlogBlogBundle:Gallery:delete.html.twig', array(
            'form' => $form->createView(),
            'id' => $gallery->getId()
        ));
    }
}
