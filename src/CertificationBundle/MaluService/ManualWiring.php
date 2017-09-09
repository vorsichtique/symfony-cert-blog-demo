<?php


namespace CertificationBundle\MaluService;


class ManualWiring
{
    protected $user;

    /**
     * ManualWiring constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getUser(){
        return $this->user;
    }
}