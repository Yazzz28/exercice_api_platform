<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 30; $i++) { 
            $post = new Post();
            $post->setTitle('Post title ' . $i);
            $post->setSlug('post-title-' . $i);
            $post->setContent('Post content ' . $i);
            $post->setCreatedAt(new \DateTimeImmutable());
            $post->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($post);
        }

        $manager->flush();
    }
}
