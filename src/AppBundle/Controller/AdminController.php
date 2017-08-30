<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AdminController extends Controller
{


    /**
     * @route("/admin/", name="admin_index")
     * @return Response
     */
    public function indexAction(){
        return new Response('ho');
    }

}