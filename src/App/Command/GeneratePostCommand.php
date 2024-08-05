<?php

namespace App\Command;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GeneratePostCommand extends Command
{
    protected EntityManagerInterface $em;
    protected LoremIpsum $loremIpsum;

    public function __construct(EntityManagerInterface $em, LoremIpsum $loremIpsum, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->loremIpsum = $loremIpsum;
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