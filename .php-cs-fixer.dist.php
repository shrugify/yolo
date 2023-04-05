<?php

declare(strict_types=1);

$config = new \PhpCsFixer\Config();

$config
    ->setRules([
        '@PSR2' => true,
        'concat_space' => false,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_functions' => true,
        ],
        'ordered_imports' => [
            'imports_order' => [
                'const',
                'class',
                'function',
            ],
        ],
        'trailing_comma_in_multiline' => [
            'elements' => [
                'arguments',
                'arrays',
                'match',
                'parameters',
            ],
        ],
    ])
;

$config->getFinder()
    ->files()
    ->name('*.php')
    ->in(__DIR__)
    ->ignoreVCSIgnored(true)
;

return $config;
