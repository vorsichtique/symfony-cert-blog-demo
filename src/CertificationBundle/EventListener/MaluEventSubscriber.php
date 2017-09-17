<?php


namespace CertificationBundle\EventListener;


use CertificationBundle\Event\MaluEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MaluEventSubscriber implements EventSubscriberInterface
{

    protected $logger;

    /**
     * MaluEventSubscriber constructor.
     * @param $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return ['malu.event' => 'onMaluEvent'];
    }

    public function onMaluEvent(MaluEvent $event){
        @trigger_error('Malu sendet deprecation', E_USER_DEPRECATED);

        $this->logger->info('malu event received');
       // dump($event->getMessage());
    }
}