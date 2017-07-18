<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 16/07/17
 * Time: 18:21
 */

namespace OC\PlatformBundle\Twig;


use OC\PlatformBundle\Antispam\OCAntispam;

class AntispamExtension extends \Twig_Extension
{
    /**
     * @var OCAntispam
     */
    private $ocAntispam;

    public function __construct(OCAntispam $ocAntispam)
    {
        $this->ocAntispam = $ocAntispam;
    }

    public function checkIfArgumentIsSpam($text){
        return $this->ocAntispam->isSpam($text);
    }


    public function getFunctions()
    {
        return [new \Twig_SimpleFunction('checkIfSpam',[$this, 'checkIfArgumentIsSpam']),];
    }
    public function getName(){
        return 'OCAntispam';
    }

}