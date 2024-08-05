<?php

namespace App\Command;

use Domain\Post\PostManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ContentGeneratorInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddPostCommand extends GeneratePostCommand
{
    protected static $defaultName = 'app:add-post';
    protected static $defaultDescription = 'Run app:add-post';

    private PostManager $postManager;

    public function __construct(PostManager $postManager, EntityManagerInterface $em, ContentGeneratorInterface $contentGenerator, string $name = null)
    {
        parent::__construct($em, $contentGenerator, $name);
        $this->postManager = $postManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Adds a post with provided title and content.')
            ->addArgument('title')
            ->addArgument('content');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $input->getArgument('title');
        $content = $input->getArgument('content');

        $this->postManager->addPost($title, $content);

        $output->writeln('The post has been added.');

        return Command::SUCCESS;
    }
}
