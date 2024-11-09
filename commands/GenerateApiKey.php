<?php

declare(strict_types=1);

namespace Commands;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateApiKey extends Command
{

    protected function configure(): void
    {
        $this
            ->setName('generate:api-keys')
            ->setDescription('Generate API keys for the application');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Generating API keys...');

        // Generate a random API key
        $apiKey = bin2hex(random_bytes(32));

        // Load existing config
        $configFile = CONFIG_PATH . 'api_keys.php';
        $config = file_exists($configFile) ? require $configFile : ['api_keys' => []];

        // Add new key to array
        $config['api_keys'][] = $apiKey;

        // Write updated config
        $contents = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        FileSystem::write($configFile, $contents);

        $output->writeln("<info>Generated new API key: $apiKey</info>");

        return Command::SUCCESS;
    }
}
