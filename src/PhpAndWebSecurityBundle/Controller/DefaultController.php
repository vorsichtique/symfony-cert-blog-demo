<?php


namespace PhpAndWebSecurityBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="php_websec_index")
     * @return Response
     */
    public function indexAction(){
        return new Response('hi');
    }

    /**
     * @Route("/xss/", name="php_websec_xss")
     * @return Response
     */
    public function xssAction(){

    }
}