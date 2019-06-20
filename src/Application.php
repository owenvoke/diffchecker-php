<?php

namespace pxgamer\DiffChecker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application as BaseApplication;

final class Application extends BaseApplication
{
    public const NAME = 'DiffChecker';
    public const VERSION = '@git-version@';

    public function __construct(?string $name = null, ?string $version = null)
    {
        if (!$version) {
            $version = static::VERSION === '@'.'git-version@' ?
                'source' :
                static::VERSION;
        }

        parent::__construct(
            $name ?: static::NAME,
            $version
        );
    }

    /**
     * @return Command[]
     */
    protected function getDefaultCommands(): array
    {
        $commands = parent::getDefaultCommands();

        $commands[] = new Commands\Authorise();
        $commands[] = new Commands\DiffChecker();

        return $commands;
    }
}
