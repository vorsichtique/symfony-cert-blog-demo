<?php


namespace CertificationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
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

    /**
     * @Assert\Type(
     *     type="integer",
     *     groups={"malugroup"}
     *     )
     */
    protected $number;

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

}