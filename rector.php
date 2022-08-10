<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Laravel\Set\LaravelSetList;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $config): void {
    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // Define what rule sets will be applied
    $config->import(LaravelSetList::LARAVEL_80);
    $config->import(SetList::DEAD_CODE);
    $config->import(SetList::PHP_80);

    // get services (needed for register a single rule)
    $services = $config->services();

    // register a single rule
    $services->set(TypedPropertyRector::class);
};
