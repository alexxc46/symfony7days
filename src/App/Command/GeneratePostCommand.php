<?php

namespace App\Command;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ContentGeneratorInterface;
use Symfony\Component\Console\Command\Command;

abstract class GeneratePostCommand extends Command
{
    protected EntityManagerInterface $em;
    protected ContentGeneratorInterface $contentGenerator;

    public function __construct(EntityManagerInterface $em, ContentGeneratorInterface $contentGenerator, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->contentGenerator = $contentGenerator;
    }

    protected function createPost(string $title, string $content): void
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);

        $this->em->persist($post);
        $this->em->flush();
    }
}