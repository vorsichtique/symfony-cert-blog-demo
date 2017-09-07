<?php


namespace AppBundle\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class StrunzExceptionListener implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            'kernel.exception' => 'onStrunzExceptionThrown'
        ];
    }

    public function onStrunzExceptionThrown(GetResponseForExceptionEvent $event){
        $event->setResponse(
            new Response('hahaha, ick hab dir in meinem eventlistener abjefangen!. eigentlich biste ne 404')
        );
    }

}