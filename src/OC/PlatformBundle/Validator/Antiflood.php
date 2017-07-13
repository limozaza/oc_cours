<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 13/07/17
 * Time: 12:06
 */

namespace OC\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class Antiflood extends Constraint
{
    public $message = "Vous avez déjà posté un message il y a moins de 15 secondes, merci d'attendre un peu.";
}