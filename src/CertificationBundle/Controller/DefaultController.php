<?php


namespace CertificationBundle\Controller;

use AppBundle\Exception\StrunzException;
use CertificationBundle\Event\MaluEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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

    /**
     * @Route("/exception/", name="certification_exception")
     */
    public function exceptionAction(){

        throw new StrunzException();

    }

    /**
     * @Route("/dispatcher/", name="certification_dispatcher")
     */
    public function dispatcherAction(EventDispatcherInterface $dispatcher){
        // Tried to inject the dispatcher into the action; don't know why it doesn't work ...
        // update: found out the reason -> controllers for this bundle didn't have the 'controller.service_arguments' tag in service.yml
        //$dispatcher->addSubscriber($this->get(MaluEventSubscriber::class));

        $dispatcher->dispatch('malu.event', new MaluEvent('Man, so eventful in here.'));

        $this->addFlash('notice', 'malu.event dispatched');

       return $this->render('certification/index.html.twig');
    }


}