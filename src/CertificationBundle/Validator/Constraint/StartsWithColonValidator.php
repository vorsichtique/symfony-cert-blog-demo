<?php


namespace CertificationBundle\Validator\Constraint;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StartsWithColonValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (':' !== substr($value, 0, 1)){
            $this->context->buildViolation($constraint->message)->setParameter('{{ string }}', $value)->addViolation();
        }
    }

}