<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 13/07/17
 * Time: 12:09
 */

namespace OC\PlatformBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntifloodValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // Pour l'instant, on considère comme flood tout message de moins de 3 caractères
        if (strlen($value) < 3) {
            // C'est cette ligne qui déclenche l'erreur pour le formulaire, avec en argument le message de la contrainte
            $this->context->addViolation($constraint->message);
        }
    }
}