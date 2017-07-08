<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 08/07/17
 * Time: 21:38
 */

namespace OC\PlatformBundle\Services\Purger;


use Doctrine\ORM\EntityManagerInterface;

class PurgerAdvert
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function purge($days){
        $advertRepo = $this->em->getRepository('OCPlatformBundle:Advert');
        $advertSkillRepo = $this->em->getRepository('OCPlatformBundle:AdvertSkill');

        $listAdverts = $advertRepo->getAdvertsNonConsulter(new \DateTime($days));

        foreach ($listAdverts as $advert){
            $advertSkills = $advertSkillRepo->findBy(['advert'=>$advert]);
            foreach ($advertSkills as $advertSkill){
                $this->em->remove($advertSkill);
            }
            $this->em->remove($advert);
        }
        $this->em->flush();
    }


}