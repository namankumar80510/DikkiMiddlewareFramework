<?php

declare(strict_types=1);

namespace Commands;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateLibrary extends Command
{

    protected function configure(): void
    {
        $this
            ->setName('generate:library')
            ->setDescription('Generate library for the application')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the library')
            ->addArgument('module', InputArgument::REQUIRED, 'The module of the library');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Generating library...');

        $name = $input->getArgument('name');
        $module = $input->getArgument('module');

        $libraryPath = MODULES_PATH . $module . '/Libraries/' . $name . '.php';
        $libraryTemplate = __DIR__ . '/templates/library.php';

        $libraryContent = str_replace('{name}', $name, file_get_contents($libraryTemplate));
        $libraryContent = str_replace('{module}', $module, $libraryContent);

        FileSystem::write($libraryPath, $libraryContent);

        $output->writeln("<info>Library generated successfully at $libraryPath</info>");
        $output->writeln('<comment>Don\'t forget to register the library in the ./config/services.php</comment>');

        return Command::SUCCESS;
    }
}
