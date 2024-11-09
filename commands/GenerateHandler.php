<?php

declare(strict_types=1);

namespace Commands;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateHandler extends Command
{

    protected function configure(): void
    {
        $this
            ->setName('generate:handler')
            ->setDescription('Generate handler for the application')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the handler')
            ->addArgument('module', InputArgument::REQUIRED, 'The module of the handler');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Generating handler...');

        $name = $input->getArgument('name');
        $module = $input->getArgument('module');

        $handlerPath = MODULES_PATH . $module . '/Handlers/' . $name . 'Handler.php';
        $handlerTemplate = __DIR__ . '/templates/handler.php';

        $handlerContent = str_replace('{name}', $name, file_get_contents($handlerTemplate));
        $handlerContent = str_replace('{module}', $module, $handlerContent);

        FileSystem::write($handlerPath, $handlerContent);

        $output->writeln("<info>Handler generated successfully at $handlerPath</info>");
        $output->writeln('<comment>Don\'t forget to register the handler in the Routes.php file of module and in ./config/services.php</comment>');

        return Command::SUCCESS;
    }
}
