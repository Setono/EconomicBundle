<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Client;

use Setono\EconomicBundle\DTO\Credentials;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class Client implements ClientInterface
{
    private HttpClientInterface $httpClient;

    private Credentials $apiCredentials;

    private string $baseUri;

    public function __construct(HttpClientInterface $httpClient, Credentials $apiCredentials, string $baseUri)
    {
        $this->httpClient = $httpClient;
        $this->apiCredentials = $apiCredentials;
        $this->baseUri = rtrim($baseUri, '/');
    }

    public function get(string $endpoint): ResponseInterface
    {
        return $this->httpClient->request('GET', $this->generateUrl($endpoint));
    }

    public function post(string $endpoint, $data): ResponseInterface
    {
        return $this->httpClient->request(
            'POST',
            $this->generateUrl($endpoint),
            $this->resolveOptions($this->resolveDataOption($data))
        );
    }

    public function put(string $endpoint, $data): ResponseInterface
    {
        return $this->httpClient->request(
            'PUT',
            $this->generateUrl($endpoint),
            $this->resolveOptions($this->resolveDataOption($data))
        );
    }

    private function resolveOptions(array $options = []): array
    {
        return array_merge_recursive([
            'headers' => [
                'Content-Type' => 'application/json',
                'X-AppSecretToken' => $this->apiCredentials->getAppSecretToken(),
                'X-AgreementGrantToken' => $this->apiCredentials->getAgreementGrantToken(),
            ]
        ], $options);
    }

    private function generateUrl(string $endpoint): string
    {
        $endpoint = ltrim($endpoint, '/');

        return sprintf('%s/%s', $this->baseUri, $endpoint);
    }

    /**
     * @param array|string|mixed $data
     */
    private function resolveDataOption($data): array
    {
        $options = [];
        if (is_string($data)) {
            $options['body'] = $data;
        } elseif (is_array($data)) {
            $options['json'] = $data;
        } else {
            throw new \InvalidArgumentException(sprintf('The provided $data must be either string or array, "%s" given', gettype($data)));
        }

        return $options;
    }
}
