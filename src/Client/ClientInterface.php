<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Client;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientInterface
{
    public function get(string $endpoint): ResponseInterface;

    /**
     * @param string|array|mixed $data
     */
    public function post(string $endpoint, $data): ResponseInterface;

    /**
     * @param string|array|mixed $data
     */
    public function put(string $endpoint, $data): ResponseInterface;
}
