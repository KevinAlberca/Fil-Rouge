<?php

/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 11/12/15
 * Time: 11:03
 */

namespace AK\BlogBundle\ORM\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AK\BlogBundle\Entity\Post;

class LoadPostFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        for($i=0; $i<100;$i++){
            $post = new Post();
            $post->setTitle(sprintf("Titre du post n: %d", $i))
                ->setBody(sprintf("Body du post n: %d", $i))
                ->setIsPublished($i%2);

            $manager->persist($post);
        }

        $manager->flush();
    }
}