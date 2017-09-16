<?php


namespace CertificationBundle\Validator\Constraint;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StartsWithColon extends Constraint
{
    public $message = 'The string "{{ string }}" doesn\'t start with a colon';

    public function validatedBy()
    {
        return StartsWithColonValidator::class;
    }

}