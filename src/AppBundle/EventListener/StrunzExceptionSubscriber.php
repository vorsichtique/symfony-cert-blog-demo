<?php


namespace AppBundle\EventListener;

use AppBundle\Exception\StrunzException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class StrunzExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onStrunzExceptionThrown'
        ];
    }

    public function onStrunzExceptionThrown(GetResponseForExceptionEvent $event){
        if ($event->getException() instanceof StrunzException) {
            $event->setResponse(
                new Response('hahaha, ick hab dir in meinem eventlistener abjefangen!')
            );
        }
    }

}