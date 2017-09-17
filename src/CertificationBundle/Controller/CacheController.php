<?php


namespace CertificationBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CacheController extends Controller
{
    /**
     * @Route("/expiration-cache", name="certification_expiration_cache")
     */
    public function expirationCacheAction(){
        $response = $this->render('certification/index.html.twig');

        $response->setSharedMaxAge(3600);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

}