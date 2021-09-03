<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Client;

final class UrlBuilder
{
    private string $baseUri;

    private ?string $endpoint = null;

    private ?int $skipPages = null;

    private ?int $pageSize = null;

    public function __construct(string $baseUri)
    {
        $this->baseUri = trim($baseUri, '/');
    }

    public static function create(string $baseUri): self
    {
        return new self($baseUri);
    }

    public function endpoint(string $endpoint): self
    {
        $new = clone $this;
        $new->endpoint = trim($endpoint, '/');

        return $new;
    }

    public function skipPages(int $skipPages): self
    {
        $new = clone $this;
        $new->skipPages = $skipPages;

        return $new;
    }

    public function pageSize(int $pageSize): self
    {
        $new = clone $this;
        $new->pageSize = $pageSize;

        return $new;
    }

    public function build(): string
    {
        $str = $this->baseUri;
        if (null !== $this->endpoint) {
            $str .= '/' . $this->endpoint;
        }

        $queryStr = '';
        if (null !== $this->skipPages) {
            $queryStr .= sprintf('skippages=%d&', $this->skipPages);
        }

        if (null !== $this->pageSize) {
            $queryStr .= sprintf('pagesize=%d&', $this->pageSize);
        }

        $queryStr = rtrim($queryStr, '&');

        if ('' !== $queryStr) {
            $str .= '?' . $queryStr;
        }

        return $str;
    }
}
