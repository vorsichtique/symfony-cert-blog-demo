<?php


namespace CertificationBundle\Entity;


class SerializableEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $number;

    /**
     * @var boolean
     */
    protected $isAwesome;

    /**
     * @return bool
     */
    public function isAwesome()
    {
        return $this->isAwesome;
    }

    /**
     * @param bool $isAwesome
     */
    public function setIsAwesome($isAwesome)
    {
        $this->isAwesome = $isAwesome;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }


}