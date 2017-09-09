<?php


namespace CertificationBundle\EventListener;


use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ManualConfigurationSubscriber implements EventSubscriberInterface
{
    protected $session;

    /**
     * ManualConfigurationSubscriber constructor.
     * @param $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return ["malu.manualconfiguration.event" => "onManualConfigurationEvent"];
    }

    public function onManualConfigurationEvent(Event $event){
       $this->session->getFlashBag()->add('notice', 'Event malu.manualconfiguration.event handled in ManualConfigurationSubscriber');
    }

}