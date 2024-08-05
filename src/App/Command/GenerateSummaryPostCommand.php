<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class GenerateSummaryPostCommand extends GeneratePostCommand
{
    protected static $defaultName = 'app:generate-summary-post';
    protected static $defaultDescription = 'Generates a summary post with the title "Summary YYYY-MM-DD"';

    protected function configure(): void
    {
        $this->setDescription('Generates a summary post with the title "Summary YYYY-MM-DD"')
            ->setHelp('This command generates a summary post with the title "Summary YYYY-MM-DD" and is run by a cron job once a day');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $today = new \DateTime();
        $title = 'Summary ' . $today->format('Y-m-d');
        $content = $this->contentGenerator->generateContent();

        $this->createPost($title, $content);

        $output->writeln('Summary post created: ' . $title);

        return Command::SUCCESS;
    }
}