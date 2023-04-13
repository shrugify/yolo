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

namespace App\Enum;

enum MessageSource: string
{
    case LocalFile = '/data/messages.txt';
    case Mixed = '';
    case TestCaseWorkAround = 'foo'; // I'm still trying to figure out a better way to kinda mock enum values
    case Undefined = '¯\_(ツ)_/¯';
    case WhatTheCommit = 'https://raw.githubusercontent.com/ngerakines/commitment/main/commit_messages.txt';
}
