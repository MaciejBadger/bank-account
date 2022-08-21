<?php

declare(strict_types=1);

namespace App\Presentation\Command;

use App\Domain\Repository\WalletRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(name: 'app:print-transaction-history')]
class PrintTransactionHistory extends Command
{
    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository,
        private readonly SerializerInterface $serializer,
        private readonly Filesystem $filesystem,
        private readonly string $projectDir
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Print transaction history')
            ->addArgument('id', InputArgument::REQUIRED, 'Wallet id')
            ->addArgument('filename', InputArgument::REQUIRED, 'Filename');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $id */
        $id = $input->getArgument('id');
        /** @var string $filename */
        $filename = $input->getArgument('filename');
        $path = $this->projectDir . '/' . $filename;

        $wallet = $this->walletRepository->get($id);

        $serialized = $this->serializer->serialize(
            $wallet->getTransactions(),
            'csv',
            ['csv_delimiter' => ';']
        );

        $this->filesystem->dumpFile($path, $serialized);

        $output->writeln(sprintf('SUCCESS: The file was exported to: %s', $path));

        return self::SUCCESS;
    }
}
