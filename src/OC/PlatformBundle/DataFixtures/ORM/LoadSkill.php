<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 03/07/17
 * Time: 16:28
 */

namespace OC\PlatformBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Skill;

class LoadSkill implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = [
            'PHP','Symfony','C++','Java','Blender',
        ];

        foreach ($names as $name)
        {
            $skill = new Skill();
            $skill->setName($name);

            $manager->persist($skill);
        }
        $manager->flush();
    }

}