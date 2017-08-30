<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class BlogController extends Controller
{
    /**
     * @Route("/blog/", name="blog_index")
     */
    public function indexAction(){
        return new Response('hi');
    }

}