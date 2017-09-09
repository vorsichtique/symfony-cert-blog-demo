<?php


namespace CertificationBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class MaluEvent extends Event
{
    protected $message;

    /**
     * MaluEvent constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage(){
        return $this->message;
    }

}