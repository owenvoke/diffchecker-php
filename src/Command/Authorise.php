<?php

namespace pxgamer\DiffChecker\Command;

use pxgamer\DiffChecker\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Authorise
 * @package pxgamer\DiffChecker\Command
 */
class Authorise extends Command
{
    protected function configure()
    {
        $this
            ->setName('auth')
            ->setDescription('Authorise your account.')
            ->setHelp('This command allows you to authorise your account using DiffChecker.com');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text([
            'Authorisation',
            '---------------'
        ]);

        if (file_exists(BIN_DIR . 'credentials.json')) {
            $json = json_decode(file_get_contents(BIN_DIR . 'credentials.json'));

            if ($json->token) {
                $io->success('Your account is already authenticated.');
                return true;
            }
        }

        $email = $io->ask('Enter your email address: ');
        $password = $io->askHidden('Enter your password: ');

        if ($data = self::authorise($email, $password)) {
            file_put_contents(BIN_DIR . 'credentials.json', json_encode(['token' => $data]));

            $io->success('Successfully authenticated your account.');
            return true;
        } else {
            $io->warning('Failed to authenticate your account. Please try again.');
            return false;
        }
    }

    /**
     * @param string|bool $email
     * @param string|bool $password
     * @return bool|string
     */
    public static function authorise($email = false, $password = false)
    {
        if (!$email && !$password) {
            if (file_exists(BIN_DIR . 'credentials.json')) {
                $json = json_decode(file_get_contents(BIN_DIR . 'credentials.json'));

                if ($json->token) {
                    return $json->token;
                }
            }
        }

        $array = [
            'email' => $email,
            'password' => $password
        ];

        $cu = curl_init();

        curl_setopt_array(
            $cu,
            [
                CURLOPT_URL => Config::API_URL . '/sessions',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($array)
            ]
        );

        $response = json_decode(curl_exec($cu));

        $token = false;

        if (isset($response->authToken)) {
            $token = $response->authToken;
        }

        return $token;
    }
}