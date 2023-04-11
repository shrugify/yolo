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

namespace App\Tests\Controller;

use App\Enum\MessageSource;
use App\Exception\CouldNotReadFromFileException;
use App\Repository\MessageRepository;
use DG\BypassFinals;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class WhatTheCommitControllerTest extends WebTestCase
{

    private KernelBrowser $client;

    protected function setUp(): void
    {
        BypassFinals::enable();
        $this->client = self::createClient();
    }

    #[Test]
    public function whatTheCommitActionReturnsContent(): void
    {
        $crawler = $this->client->request('GET', '/whatthecommit.txt');
        self::assertResponseIsSuccessful();
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[Test]
    public function whatTheCommitActionReturnsDefaultAfterExceptionIsCaught(): void
    {
        /** @phpstan-ignore-next-line */
        $mockRepo = $this->createMock(MessageRepository::class);
        $mockRepo->method('getRandomMessageBySource')
            ->willThrowException(new CouldNotReadFromFileException());

        $controller = new \App\Controller\WhatTheCommitController($mockRepo);
        $response = $controller->whatTheCommitAction();

        self::assertEquals(MessageSource::Undefined->value, $response->getContent());
    }
}
