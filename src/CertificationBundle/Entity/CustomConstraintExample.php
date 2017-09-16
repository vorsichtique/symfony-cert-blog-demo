<?php


namespace CertificationBundle\Entity;

use CertificationBundle\Validator\Constraint as MaluAssert;

class CustomConstraintExample
{

    /**
     * @MaluAssert\StartsWithColon
     */
    protected $title;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


}