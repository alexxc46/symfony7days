<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRandomPostCommand extends GeneratePostCommand
{
    protected static $defaultName = 'app:generate-random-post';
    protected static $defaultDescription = 'Run app:generate-random-post';

    protected function configure(): void
    {
        $this->setDescription('Generates a random post with a random title and content.')
            ->setHelp('This command generates a random post and is run by a cron job three times a day');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $this->loremIpsum->words(mt_rand(4, 6));
        $content = $this->loremIpsum->paragraphs(2);

        $this->createPost($title, $content);

        $output->writeln('A random post has been generated.');

        return Command::SUCCESS;
    }
}