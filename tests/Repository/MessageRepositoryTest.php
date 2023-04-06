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

namespace App\Tests\Repository;

use App\Enum\MessageSource;
use App\Exception\CouldNotReadFromFileException;
use App\Repository\MessageRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MessageRepositoryTest extends TestCase
{
    /** @phpstan-ignore-next-line  */
    private readonly MessageRepository $messageRepository;

    protected function setUp(): void
    {
        /** @phpstan-ignore-next-line  */
        $this->messageRepository = new MessageRepository();
    }

    /**
     * @throws CouldNotReadFromFileException
     */
    #[Test]
    public function testGetRandomMessage(): void
    {
        self::assertSame(
            MessageSource::Undefined->value,
            $this->messageRepository->getRandomMessage(null),
        );

        $localMessage = $this->messageRepository->getRandomMessage(MessageSource::LocalFile);
        self::assertFileExists(
            $this->messageRepository->getPathToLocalFile(
                MessageSource::LocalFile->value,
            ),
        );

        // @todo: expect excpetion
        self::assertNotEmpty($localMessage);

        $localMessage = $this->messageRepository->getRandomMessage(MessageSource::WhatTheCommit);
        self::assertNotEmpty($localMessage);
    }
}
