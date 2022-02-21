<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Client;

use Setono\EconomicBundle\DTO\Credentials;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

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

    public function createUrlBuilder(): UrlBuilder
    {
        return UrlBuilder::create($this->baseUri);
    }

    public function get(string $url): ResponseInterface
    {
        return $this->httpClient->request('GET', $url, $this->resolveOptions());
    }

    public function post(string $url, $data): ResponseInterface
    {
        return $this->httpClient->request(
            'POST',
            $url,
            $this->resolveOptions($this->resolveDataOption($data))
        );
    }

    public function put(string $url, $data): ResponseInterface
    {
        return $this->httpClient->request(
            'PUT',
            $url,
            $this->resolveOptions($this->resolveDataOption($data))
        );
    }

    public function getPageCount(string $url): int
    {
        $data = $this->get($url)->toArray();

        Assert::keyExists($data, 'pagination', 'Not a collection');
        Assert::isArray($data['pagination']);
        Assert::keyExists($data['pagination'], 'results', 'No results key on the collection. This should not be possible');
        Assert::integer($data['pagination']['results']);
        Assert::keyExists($data['pagination'], 'pageSize', 'No pageSize key on the collection. This should not be possible');
        Assert::integer($data['pagination']['pageSize']);

        return (int) ceil($data['pagination']['results'] / $data['pagination']['pageSize']);
    }

    private function resolveOptions(array $options = []): array
    {
        return array_merge_recursive([
            'headers' => [
                'Content-Type' => 'application/json',
                'X-AppSecretToken' => $this->apiCredentials->getAppSecretToken(),
                'X-AgreementGrantToken' => $this->apiCredentials->getAgreementGrantToken(),
            ],
        ], $options);
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
