<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\EventNames;
use AppBundle\Form\CommentType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BlogPost;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return $this->render('app/blog/index.' . $_format . '.twig',
            [
                'bps' => $bps]
        );
    }

    /**
     * @Route("/posts/{slug}", name="blog_show")
     */
    public function showAction(BlogPost $post){
        dump($post);

        return $this->render('app/blog/show.html.twig',
            ['post' => $post]
        );
    }

    /**
     * This controller is called directly via the render() function in the
     * blog/post_show.html.twig template. That's why it's not needed to define
     * a route name for it.
     *
     * The "id" of the Post is passed in and then turned into a Post object
     * automatically by the ParamConverter.
     *
     */
    public function commentFormAction(BlogPost $post){
        $commentForm = $this->createForm(CommentType::class);

        return $this->render('app/blog/_form.comment.html.twig', ['form' => $commentForm->createView(), 'post' => $post]);
    }


    /**
     * @Route("/comment/{postSlug}/new", name="comment_new")
     * @ParamConverter("blogPost", options={"mapping": {"postSlug": "slug"}})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     */
    public function createCommentAction(
        Request $request,
        BlogPost $blogPost,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ){
        $comment = new Comment();
        $comment->setCreationDate(new \DateTime());
        $comment->setAuthor($this->getUser());
        $blogPost->addComment($comment);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $event = new GenericEvent($comment);

            $eventDispatcher->dispatch(EventNames::COMMENT_CREATED, $event);

            $logger->info(EventNames::COMMENT_CREATED . ' dispatched');

            $this->addFlash('success', 'comment added');

            return $this->redirectToRoute('blog_show', ['slug' => $blogPost->getSlug()]);
        }
    }

    /**
     * @Route("/posts/{id}/edit", name="blog_edit")
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

        return $this->render('app/blog/edit.html.twig',
            ['form' => $form->createView(),
                'bp' => $post
            ]);
    }

    /**
     * @Route("posts/{id}/delete", name="blog_delete")
     * @Security("is_granted('delete', blogPost)")
     */
    public function deleteAction(BlogPost $blogPost){
        $em = $this->getDoctrine()->getManager();
        $em->remove($blogPost);
        $em->flush();

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/search", name="blog_search")
     */
    public function searchAction(Request $request){
        if (!$request->isXmlHttpRequest()) {
            return $this->render('app/blog/search.html.twig');
        }

        $query = $request->query->get('q', '');
        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findBySearchQuery($query);

        $results = [];
        foreach ($posts as $post) {
           $results[] = [
             'title' => $post->getTitle(),
               'url' => $this->generateUrl('blog_show', ['slug' => $post->getSlug()]),

           ];
        }
        return new JsonResponse($results);
    }



}