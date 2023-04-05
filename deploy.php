<?php declare(strict_types=1);

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

namespace Deployer;

require 'recipe/common.php';
require 'contrib/rsync.php';

set('application', 'yolo');
set('keep_releases', 3);

set('rsync_src', __DIR__);
set('rsync', [
    'exclude' => [
        '/.ddev',
        '/.github',
        '/.git',
        '/bin/phpunit',
        '/tests',
        '/var',
        '/.editorconfig',
        '/.env.local.php',
        '/.gitattributes',
        '/.gitignore',
        '/.php-cs-fixer.cache',
        '/.php-cs-fixer.dist.php',
        'deploy.php',
        'phpstan.php',
        'phpstan-baseline.php',
        'phpunit.xml.dist',
        'rector.php',
        'renovate.json',
    ],
    'exclude-file' => false,
    'include' => [],
    'include-file' => false,
    'filter' => [],
    'filter-file' => false,
    'filter-perdir' => false,
    'flags' => 'az',
    'options' => ['delete', 'delete-after', 'force'],
    'timeout' => 3600,
]);
set('shared_files', [
    '.env.local',
]);
set('shared_dirs', [
    'var/log',
]);

// Symfony
set('bin/console', '{{bin/php}} {{release_or_current_path}}/bin/console');

// Hosts
host('production')
    ->set('hostname', 'musca.uberspace.de')
    ->set('remote_user', 'api')
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', '~/html/yolo.shrugify.com')
    ->add('env', ['APP_ENV' => 'prod'])
;

// Symfony tasks
task('symfony:cache:clear', function () {
    run('{{bin/console}} cache:clear');
});
task('symfony:cache:warmup', function () {
    run('{{bin/console}} cache:warmup');
});
task('symfony', [
    'symfony:cache:clear',
    'symfony:cache:warmup',
]);

// Main deploy task
task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'symfony',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success',
])->desc('Deploy your project');

// Unlock after failed
after('deploy:failed', 'deploy:unlock');
