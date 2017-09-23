<?php


namespace CertificationBundle\MaluService;


use Psr\Log\LoggerInterface;

class DirectServiceDefinitionService
{
    protected $logger;

    protected $message;

    /**
     * DirectServiceDefinitionService constructor.
     * @param $logger
     * @param $message
     */
    public function __construct(LoggerInterface $logger, $message)
    {
        $this->logger = $logger;
        $this->message = $message;
    }


    public function logEarly(){
        $this->logger->debug('Logged via compiler pass: ' . $this->message);
    }
}