<?php


namespace CertificationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class ValidationExample
{

    protected $name;


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload){
        dump($context);
        dump($payload);
        if ($this->getName() == 'bidde'){
            return;
        }
        $context
            ->buildViolation('Say the magic word')
            ->atPath('name')
            ->addViolation();
    }
}