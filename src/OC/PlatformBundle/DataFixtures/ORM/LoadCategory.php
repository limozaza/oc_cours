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
use OC\PlatformBundle\Entity\Category;

class LoadCategory implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = [
            'Développement web','Développement mobile','Graphisme','Intégration','Réseau',
        ];

        foreach ($names as $name)
        {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
        }
        $manager->flush();
    }

}