<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 30/06/17
 * Time: 22:40
 */

namespace OC\PlatformBundle\Antispam;


class OCAntispam
{

    private $mailer;
    private $minLength;
    private $locale;

    public function __construct(\Swift_Mailer $mailer, $minLength, $locale)
    {
        $this->mailer     = $mailer;
        $this->minLength  = $minLength;
        $this->locale     = $locale;
    }

    /**
     * Vérifie si le texte est un spam ou non
     *
     * @param string $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text) < $this->minLength;
    }
}