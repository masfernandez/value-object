<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets(
        [
            SetList::CODE_QUALITY,
            SetList::DEAD_CODE,
            SetList::TYPE_DECLARATION,
            SetList::PHP_81,
        ]
    );

    $rectorConfig->paths(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ]
    );

    $rectorConfig->skip(
        []
    );

    $rectorConfig->autoloadPaths(
        []
    );

    // php-stan
    $rectorConfig->phpstanConfig(getcwd() . '/phpstan.neon');
};