<?php


namespace CertificationBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="certification_index")
     * @return Response
     */
    public function indexAction(){
        return $this->render('certification/index.html.twig');
    }


}