<?php


namespace AppBundle\EventListener;


use AppBundle\EventNames;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class CommentNotificationSubscriber implements EventSubscriberInterface
{

    protected $logger;

    /**
     * CommentNotificationSubscriber constructor.
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
        return [
            EventNames::COMMENT_CREATED => 'onCommentCreated',
        ];
    }

    public function onCommentCreated(GenericEvent $event){
        $this->logger->notice(EventNames::COMMENT_CREATED . ' heard');
    }

}