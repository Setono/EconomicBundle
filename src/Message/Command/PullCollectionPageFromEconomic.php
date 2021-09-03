<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Message\Command;

use Setono\EconomicBundle\Resource\ResourceInterface;
use Setono\JobStatusBundle\Entity\JobInterface;
use Webmozart\Assert\Assert;

final class PullCollectionPageFromEconomic
{
    private string $resource;

    private int $jobId;

    private string $url;

    /**
     * @param string|ResourceInterface|mixed $resource
     * @param int|JobInterface|mixed $job
     */
    public function __construct($resource, $job, string $url)
    {
        if ($resource instanceof ResourceInterface) {
            $resource = $resource->getName();
        }
        Assert::string($resource);

        if ($job instanceof JobInterface) {
            $job = $job->getId();
        }
        Assert::integer($job);

        $this->resource = $resource;
        $this->jobId = $job;
        $this->url = $url;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function getJobId(): int
    {
        return $this->jobId;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
