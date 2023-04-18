<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony project "shrugify/yolo".
 *
 * Copyright (C) 2023 Martin Adler <mteu@mailbox.org>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

$configuration = require 'phpstan-baseline.php';

$configuration['parameters']['level'] = 'max';
$configuration['parameters']['paths'] = [
    'config',
    'public',
    'src',
    'tests',
];

$configuration['parameters']['symfony'] = [
    'consoleApplicationLoader' => 'tests/bootstrap.php',
];
$configuration['parameters']['ergebnis'] = [
    'classesAllowedToBeExtended' => [
        Exception::class,
        \App\Exception\Exception::class,
        \Symfony\Component\HttpKernel\Kernel::class,
        \Mockery\Adapter\Phpunit\MockeryTestCase::class,
        \Symfony\Bundle\FrameworkBundle\Test\WebTestCase::class,
    ],
];

$configuration['parameters']['type_coverage'] = [
    'return_type' => 100,
    'param_type' => 100,
    'property_type' => 100,
    'print_suggestions' => true,
];

$ignoreErrors = [
    '#^Interface must be located in "Contract" or "Contracts" namespace$#',
    '#^Use separate function calls with readable variable names$#',
];

foreach ($configuration['parameters']['ignoreErrors'] as $baselineIgnore) {
    $ignoreErrors[] = $baselineIgnore['message'];
}

$configuration['parameters']['ignoreErrors'] = array_unique($ignoreErrors);

$configuration['parameters']['docblock'] = [
    'copyrightIdentifier' => 'Copyright (C) 2023',
    'requiredLicenseIdentifier' => 'GPL-3.0',
];

return $configuration;
