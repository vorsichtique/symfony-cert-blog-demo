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
     * @Route("/", name="blog_index", defaults={"page": "1"})
     * @Route("/{page}", name="blog_index_paginated", requirements={"page": "\d+" })
     */
    public function indexAction($page){

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(BlogPost::class);
        $bps = $repo->findCurrent($page);

        if (count($bps) === 0) {
            $this->addFixtures();
            $bps = $repo->findCurrent($page);
        }

        return $this->render('blog/index.html.twig',
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

    protected function addFixtures(){
        $em = $this->getDoctrine()->getManager();

        $tagStrings = ['aaaaaa', 'bbbbbb', 'cccmcc', 'ooooo'];
        $tags = [];

        foreach ($tagStrings as $tag) {
            $newTag = new Tag();
            $newTag->setLabel($tag);
            $tags[] = $newTag;
        }

        $i = 0;
        $titleOrg = file_get_contents('https://loripsum.net/api/1/plaintext');
        $titleOrg = strtolower($titleOrg);
        $titleOrg = preg_replace('/[^a-z\s]/', '', $titleOrg);


        while($i < 10) {
            $bp = new BlogPost();
            $title = explode(' ', $titleOrg);
            shuffle($title);
            $title = array_slice($title, 0, 7);
            $title = implode(' ', $title);
            $title = ucfirst($title);
            $bp->setTitle($title);
            $bp->setSlug(str_replace(' ', '-', strtolower($title)));

            $content = file_get_contents('https://loripsum.net/api/plaintext');
            $bp->setContent($content);
            $bp->setPublicationDate(new \DateTime());

            shuffle($tags);
            $bp->addTag($tags[0]);

            $em->persist($bp);

            $i++;
        }

        $em->flush();

    }

}