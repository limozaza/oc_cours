<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 18/07/17
 * Time: 16:04
 */

namespace OC\PlatformBundle\Beta;


use Symfony\Component\HttpFoundation\Response;

class BetaHTMLAdder
{
    public function addBeta(Response $response, $remainingDays){
        $content = $response->getContent();

        $html = '<div style="position: absolute; top: 0; background: orange; width: 100%; text-align: center; padding: 0.5em;">Beta J-'.$remainingDays.' !</div>';
        $content = str_replace('<body>','<body> '.$html,$content);

        $response->setContent($content);
        return $response;
    }
}