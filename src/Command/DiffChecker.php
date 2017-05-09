<?php

namespace pxgamer\DiffChecker\Command;

use pxgamer\DiffChecker\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class DiffChecker
 * @package pxgamer\DiffChecker\Command
 */
class DiffChecker extends Command
{
    protected function configure()
    {
        $this
            ->setName('diff')
            ->setDescription('Compares two files.')
            ->setHelp('This command allows you to compare two files using DiffChecker.com');

        $this->addArgument('file_1', InputArgument::REQUIRED, 'The first file to compare.');
        $this->addArgument('file_2', InputArgument::REQUIRED, 'The second file to compare.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text([
            'Diff Comparison',
            '---------------'
        ]);

        $file_1 = $input->getArgument('file_1');
        $file_2 = $input->getArgument('file_2');

        $link = self::diff($file_1, $file_2);

        $io->table(
            [
                'Name',
                'Value'
            ],
            [
                [
                    'File 1',
                    $file_1
                ],
                [
                    'File 2',
                    $file_2
                ],
                [
                    'Response',
                    $link->text
                ]
            ]
        );
    }

    /**
     * @param string $file_1
     * @param string $file_2
     * @param string $expires
     * @return object
     */
    public static function diff($file_1, $file_2, $expires = 'forever')
    {
        $response = new \stdClass();

        if (!file_exists($file_1) || !file_exists($file_2)) {
            $response->status = false;
            $response->text = 'File(s) not found. Please check your file paths.';
            return $response;
        }

        if ($token = Authorise::authorise()) {
            $cu = curl_init();

            $array = [
                'left' => file_get_contents($file_1),
                'right' => file_get_contents($file_2),
                'expires' => $expires
            ];

            curl_setopt_array(
                $cu,
                [
                    CURLOPT_URL => Config::API_URL . '/diffs',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query($array),
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Bearer ' . $token
                    ]
                ]
            );

            $curl_response = json_decode(curl_exec($cu));

            $response->status = true;
            $response->text = isset($curl_response->slug) ? Config::BASE_URL . '/' . $curl_response->slug : 'Failed to create diff.';
            return $response;
        } else {
            $response->status = false;
            $response->text = 'Failed to authenticate your account. Please try again.';
            return $response;
        }
    }
}