<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Client;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientInterface
{
    public function createUrlBuilder(): UrlBuilder;

    public function get(string $url): ResponseInterface;

    /**
     * @param string|array|mixed $data
     */
    public function post(string $url, $data): ResponseInterface;

    /**
     * @param string|array|mixed $data
     */
    public function put(string $url, $data): ResponseInterface;

    public function getPageCount(string $url): int;
}
