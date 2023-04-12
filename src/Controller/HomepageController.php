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

namespace App\Controller;

use App\Enum\MessageSource;
use App\Exception\CouldNotReadFromFileException;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final readonly class HomepageController
{
    public function __construct(
        private Environment $twig,
        private MessageRepository $messageRepository,
        private RouterInterface $router,
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    #[Route(path: '/')]
    public function homepageAction(): Response
    {
        return new Response(
            $this->twig->render(
                'homepage.html.twig',
                [
                    'message' => $this->messageRepository->getRandomMessageBySource(MessageSource::Mixed),
                    'routes' => $this->getRoutes(),
                ],
            ),
        );
    }

    /**
     * @return array<string, \Symfony\Component\Routing\Route>
     */
    private function getRoutes(): array
    {
        return array_filter(
            $this->router->getRouteCollection()->all(),
            static fn (\Symfony\Component\Routing\Route $route) => str_ends_with($route->getPath(), '.txt'),
        );
    }
}
