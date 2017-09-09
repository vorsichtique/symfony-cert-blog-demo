<?php


namespace CertificationBundle\Controller;

use AppBundle\Exception\StrunzException;
use CertificationBundle\Event\MaluEvent;
use CertificationBundle\EventListener\ManualConfigurationSubscriber;
use CertificationBundle\MaluService\ManualWiring;
use CertificationBundle\MaluService\ParameterInjection;
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
    public function indexAction()
    {
        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/exception/", name="certification_exception")
     */
    public function exceptionAction()
    {

        throw new StrunzException();

    }

    /**
     * @Route("/dispatcher/", name="certification_dispatcher")
     */
    public function dispatcherAction(EventDispatcherInterface $dispatcher)
    {
        // Tried to inject the dispatcher into the action; don't know why it doesn't work ...
        // update: found out the reason -> controllers for this bundle didn't have the 'controller.service_arguments' tag in service.yml
        //$dispatcher->addSubscriber($this->get(MaluEventSubscriber::class));

        $dispatcher->dispatch('malu.event', new MaluEvent('Man, so eventful in here.'));

        $this->addFlash('notice', 'malu.event dispatched');

        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/service/parameter-injection", name="certification_service_parameter_injection")
     */
    public function serviceParameterInjectionAction(ParameterInjection $pi)
    {
        $this->addFlash('notice', $pi->getMail() . " (I was injected as an argument into a service)");

        $this->addFlash('notice', $this->getParameter('parameter_injection_mail') . " (I was fetched directly as a parameter)");

        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/service/manuel-wiring", name="certification_service_manuel_wiring")
     */
    public function manuelWiringAction(ManualWiring $mw)
    {
        $this->addFlash('notice', $mw->getUser() . " (taken from the service alias that point to the standard user service)");

        $mwsuper = $this->get('malu.manuelwiring.superuser');

        $this->addFlash('notice', $mwsuper->getUser() . " (taken from the superuser service)");

        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/service/manuel-configuration", name="certification_service_manuel_configuration")
     */
    public function manuelConfigurationAction(EventDispatcherInterface $dispatcher)
    {
        $dispatcher->dispatch('malu.manualconfiguration.event');


       // $this->addFlash('notice', $mw->getUser() . " (taken from the service alias that point to the standard user service)");


       // $this->addFlash('notice', $mwsuper->getUser() . " (taken from the superuser service)");

        return $this->render('certification/index.html.twig');
    }


}