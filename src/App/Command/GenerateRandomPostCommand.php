<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class GenerateRandomPostCommand extends GeneratePostCommand
{
    protected static $defaultName = 'app:generate-random-post';
    protected static $defaultDescription = 'Generates a random post with a random title and content.';

    protected function configure(): void
    {
        $this->setDescription('Generates a random post with a random title and content.')
            ->setHelp('This command generates a random post and is run by a cron job three times a day');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $this->contentGenerator->generateTitle();
        $content = $this->contentGenerator->generateContent();

        $this->createPost($title, $content);

        $output->writeln('A random post has been generated.');

        return Command::SUCCESS;
    }
}
