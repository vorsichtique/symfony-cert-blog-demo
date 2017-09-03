<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->render('base.html.twig');
    }

}