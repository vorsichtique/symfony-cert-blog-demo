<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BlogPost;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\BlogPostType;

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
     * @Route("/blog/{slug}", name="blog_show")
     */
    public function showAction(BlogPost $post){

        return $this->render('blog/show.html.twig', ['post' => $post]);

    }

    /**
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function editAction(Request $request, BlogPost $post){
        $form = $this->createForm(BlogPostType::class, $post);
        $form->handleRequest($request);
        dump($form);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('blog/edit.html.twig', ['form' => $form->createView()]);
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
            $bp->setSlug(str_replace(' ', '-', strtolower($title)));

            $content = file_get_contents('https://loripsum.net/api/plaintext');
            $bp->setContent($content);
            $bp->setPublicationDate(new \DateTime());
            $em->persist($bp);

            $i++;
        }

        $em->flush();

    }

}