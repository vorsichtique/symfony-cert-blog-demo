<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BlogPost;


class BlogController extends Controller
{
    /**
     * @Route("/blog/", name="blog_index")
     */
    public function indexAction(){
        $bp = new BlogPost();
        $bp->setTitle('ahahaha');

        $bp2 = new BlogPost();
        $bp2->setTitle('ohohoho');

        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(BlogPost::class);

        $em->persist($bp);
        $em->persist($bp2);

        $em->flush();

        $bps = $repo->findAll();

        return $this->render('blog/index.html.twig', ['bps' => $bps]);
    }

}