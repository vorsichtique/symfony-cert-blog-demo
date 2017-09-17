<?php


namespace CertificationBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ControllerController
 * @package CertificationBundle\Controller
 *
 * Extending the Abstractcontroller instead of Controller prevents direct container access via $this->get();
 */
class ControllerController extends AbstractController
{
    /**
     * @Route("controller-default", name="certification_controller_default")
     */
    public function defaultAction() {
        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("controller-redirect-to-route", name="certification_controller_redirect_to_route")
     */
    public function redirectToRouteAction(){
        $this->addFlash('notice', 'Redirected from certification_controller_redirect_to_route to certification_controller_default');

        return $this->redirectToRoute('certification_controller_default');
    }

    /**
     * @Route("controller-redirect-externally", name="certification_controller_redirect_externally")
     */
    public function redirectExternallyAction(){
        $this->addFlash('notice', 'Redirected from certification_controller_redirect_to_route to symfony.com');

        return $this->redirect('https://www.symfony.com');
    }

    /**
     * @Route("controller-404", name="certification_controller_404")
     */
    public function fileNotFoundAction(){

        throw $this->createNotFoundException('Mich gibt es nicht');
    }

    /**
     * @Route("controller-cookie", name="certification_controller_cookie")
     */
    public function cookieAction(Request $request){
        dump($request->cookies);

        $response =  $this->render('certification/index.html.twig');
        $response->headers->setCookie(new Cookie('malu', 'yummie'));
        return $response;
    }
}