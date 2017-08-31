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

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(BlogPost::class);
        $bps = $repo->findAll();

        if (count($bps) === 0) {
            $this->addFixtures();
            $bps = $repo->findAll();
        }

        return $this->render('blog/index.html.twig', ['bps' => $bps]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function showAction($id){
        $post = $this->getDoctrine()->getManager()->getRepository(BlogPost::class)->find($id);

        return $this->render('blog/show.html.twig', ['post' => $post]);

    }

    protected function addFixtures(){
        $i = 0;
        $em = $this->getDoctrine()->getManager();
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

            $content = file_get_contents('https://loripsum.net/api/plaintext');
            $bp->setContent($content);
            $bp->setPublicationDate(new \DateTime());
            $em->persist($bp);

            $i++;
        }

        $em->flush();

    }

}