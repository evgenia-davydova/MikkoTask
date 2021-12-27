<?php

Namespace Commands;

use Moneyday\PaymentPeriod;
use Moneyday\PaymentMonth;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class MoneydayCommand
 * @package Commands
 */
class MoneydayCommand extends Command
{
    protected static $defaultName = 'app:payment-report';
    private $sourcePath = __DIR__ . '/../../reports/';

    protected function configure(): void
    {
        $this
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'define the .csv file name')
            ->setHelp('This command allows you to create .csv file');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * I believe that it was more convenient to form the file name based on the date
         * for example: report_from_27-12-2021
         * But in the diagram attached to the assignment
         * "Read output filename from cli args"
         */
        $reportFile = $input->getArgument('filename');

        if (strpos($reportFile, '.csv') === false) {
            $reportFile .= '.csv';
        }

        try {
            $filesystem = new Filesystem();

            if (!$filesystem->exists($this->sourcePath)) {
                $filesystem->mkdir($this->sourcePath);
            };
        } catch (IOExceptionInterface $exception) {
            $output->writeln('Error!Could not create directory at ' . $exception->getPath());
            return Command::FAILURE;
        }

        try {
            $period = new PaymentPeriod();
            $remainingMonths = $period->getPaidPeriod();
        } catch (\Exception $e) {
            $output->writeln('Error!Could not determine remaining months in this year ' . $e->getMessage());
            return Command::FAILURE;
        }

        $csvData = 'Month,Salary day,Bonus day' . PHP_EOL;

        try {
            foreach ($remainingMonths as $month) {
                $monthPayday = new PaymentMonth($month);
                $csvData .= implode(',', [
                    $monthPayday->getMonth(),
                    $monthPayday->getSalaryDay(),
                    $monthPayday->getBonusDay()
                    ]). PHP_EOL;
            }
            $filesystem->dumpFile($this->sourcePath . $reportFile, $csvData);
        } catch (\Exception $e) {
            $output->writeln('Error!Could not determine dates ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Success!The payment dates for the remainder of this year in reports/' . $reportFile);
        return Command::SUCCESS;
    }
}
