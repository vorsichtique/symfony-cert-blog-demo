<?php


namespace CertificationBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TwigController extends Controller
{
    /**
     * @Route("/twig", name="certification_twig")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function twigAction(){
       return $this->render('certification/twig.html.twig');
    }
}