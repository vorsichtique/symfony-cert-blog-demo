<?php


namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @route("/", name="admin_index")
     * @return Response
     */
    public function indexAction(){
        return $this->render('app/admin/index.html.twig');
    }

    /**
     *
     * @Route("/new", name="blog_new")
     *
     **/
    public function newAction(Request $request){
        $post = new BlogPost();

        $form = $this->createForm(BlogPostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post->setAuthor($this->getUser());
            $post->setSlug(str_replace(' ', '-', strtolower($post->getTitle())));
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('app/admin/new.html.twig', ['bp' => $post, 'form' => $form->createView()]);

    }

}