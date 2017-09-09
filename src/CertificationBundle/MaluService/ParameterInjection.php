<?php


namespace CertificationBundle\MaluService;


class ParameterInjection
{
    protected $mail;

    /**
     * ParameterInjection constructor.
     * @param $mail
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    public function getMail(){
        return $this->mail;
    }

}