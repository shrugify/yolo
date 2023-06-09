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

namespace App\Repository;

use App\Enum\MessageSource;
use App\Exception\CouldNotReadFromFileException;
use Random\Randomizer;

final class MessageRepository implements Repository
{
    public const LEVELS_TO_ROOT = 2;

    public function getRandomMessageBySource(?MessageSource $source): string
    {
        return match ($source) {
            MessageSource::Mixed => $this->getRandomMessageFromVariousSources(),
            MessageSource::LocalFile => $this->getRandomMessageFromFile(
                $this->getPathToLocalFile($source->value),
            ),
            MessageSource::WhatTheCommit => $this->getRandomMessageFromFile(
                $source->value,
                false,
            ),
            default => MessageSource::Undefined->value,
        };
    }

    public function getPathToLocalFile(string $relativePath): string
    {
        return dirname(__DIR__, self::LEVELS_TO_ROOT) . $relativePath;
    }

    /**
     * @return string[]
     * @throws CouldNotReadFromFileException
     */
    public function getMessageArrayFromFile(string $filePath): array
    {
        /** @phpstan-ignore-next-line */
        $fileContents = @file_get_contents($filePath);

        if (false === $fileContents) {
            throw CouldNotReadFromFileException::create($filePath);
        }

        return explode(PHP_EOL, $fileContents);
    }

    public function getRandomMessageFromFile(string $filePath, bool $prefixMessage = true): string
    {
        try {
            $messagesArray = $this->getMessageArrayFromFile($filePath);
        } catch (CouldNotReadFromFileException) {
            return MessageSource::Undefined->value;
        }

        $randomizer = new Randomizer();

        if ($prefixMessage) {
            $prefixArray = [
                '',
                '',
                '',
                '',
                '',
                '',
                '[TASK] ',
                '[BUGFIX] ',
                '🚨 ',
            ];
        }

        return $prefixMessage ? $prefixArray[$randomizer->getInt(0, count($prefixArray) - 1)] . $messagesArray[$randomizer->getInt(0, count($messagesArray) - 1)] :  $messagesArray[$randomizer->getInt(0, count($messagesArray) - 1)];
    }

    private function getRandomMessageFromVariousSources(): string
    {
        $source = [
            MessageSource::LocalFile,
            MessageSource::WhatTheCommit,
        ];

        $randomizer = new Randomizer();

        return $this->getRandomMessageBySource(
            $source[
                $randomizer->getInt(
                    0,
                    count($source) - 1,
                )
            ],
        );
    }
}
