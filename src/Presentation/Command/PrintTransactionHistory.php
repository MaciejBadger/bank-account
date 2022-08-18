<?php

declare(strict_types=1);

namespace App\Presentation\Command;

use App\Domain\Repository\WalletRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class PrintTransactionHistory extends Command
{
    protected static $defaultName = 'app:print-transaction-history';

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
        $this->setDescription('Print transaction history');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $question = new Question('Please enter valid wallet id: ');
        /** @var SymfonyQuestionHelper $helper */
        $helper = $this->getHelper('question');
        /** @var string $id */
        $id = $helper->ask($input, $output, $question);
        $filename = time() . '.csv';
        $path = $this->projectDir . '/var/' . $filename;

        try {
            $wallet = $this->walletRepository->get($id);

            $serialized = $this->serializer->serialize(
                $wallet->getTransactions(),
                'csv',
                ['csv_delimiter' => ';']
            );

            $this->filesystem->dumpFile($path, $serialized);
        } catch (\Exception $exception) {
            $output->writeln('-------------------------------------');
            $output->writeln('EXPORT FAILED');
            $output->writeln('-------------------------------------');
            $output->writeln(sprintf('Exception message: %s', $exception->getMessage()));
            $output->writeln('-------------------------------------');

            return self::FAILURE;
        }
        $output->writeln('-------------------------------------');
        $output->writeln('EXPORT PASSED');
        $output->writeln('-------------------------------------');
        $output->writeln(sprintf('The file was exported to: %s', $path));
        $output->writeln('-------------------------------------');

        return self::SUCCESS;
    }
}
