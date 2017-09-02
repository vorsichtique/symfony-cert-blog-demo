<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BlogPost;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\BlogPostType;

/**
 * @Route("/blog")
 */
class BlogController extends Controller
{
    const ITEMS_PER_PAGE = 3;

    /**
     * @Route("/",  name="blog_index", defaults={"page": "1"})
     * @Route("/rss.xml", defaults={"page": "1", "_format"="xml"}, name="blog_rss")
     * @Route("/{page}.{_format}", name="blog_index_paginated", requirements={"page": "\d+" })
     */
    public function indexAction($page, $_format = 'html'){

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(BlogPost::class);
        $bps = $repo->findCurrent($page);

        return $this->render('blog/index.' . $_format . '.twig',
            [
                'bps' => $bps]
        );
    }

    /**
     * @Route("/{slug}", name="blog_show")
     */
    public function showAction(BlogPost $post){

        return $this->render('blog/show.html.twig', ['post' => $post]);

    }

    /**
     * @Route("/{id}/edit", name="blog_edit")
     */
    public function editAction(Request $request, BlogPost $post){
        $form = $this->createForm(BlogPostType::class, $post);
        $form->handleRequest($request);
        dump($form);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'buono!!');

            return $this->redirectToRoute('blog_edit', ['id' => $post->getId()]);
        }

        return $this->render('blog/edit.html.twig',
            ['form' => $form->createView(),
                'bp' => $post
            ]);
    }

    /**
     * @Route("/{id}/delete", name="blog_delete")
     */
    public function deleteAction(BlogPost $blogPost){
        $em = $this->getDoctrine()->getManager();
        $em->remove($blogPost);
        $em->flush();

        return $this->redirectToRoute('blog_index');
    }

}