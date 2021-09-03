<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Pusher;

use Setono\EconomicBundle\Client\ClientInterface;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Resource\Resolver\ResolverInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\Assert;

final class EntityPusher implements EntityPusherInterface
{
    private SerializerInterface $serializer;

    private ResolverInterface $endpointResolver;

    private ClientInterface $client;

    public function __construct(
        SerializerInterface $serializer,
        ResolverInterface $endpointResolver,
        ClientInterface $client
    ) {
        $this->serializer = $serializer;
        $this->endpointResolver = $endpointResolver;
        $this->client = $client;
    }

    public function pushEntity(EconomicAwareInterface $entity): void
    {
        $endpoint = $this->endpointResolver->resolveEndpoint($entity);
        $economicIdentifier = $entity->getEconomicIdentifier();

        $data = $this->serializer->serialize($entity, 'json', ['groups' => 'setono:economic:push']);

        if (null === $economicIdentifier) {
            $response = $this->client->post($endpoint->getBaseUri(), $data);
        } else {
            $response = $this->client->put(sprintf('%s/%s', $endpoint->getBaseUri(), $economicIdentifier), $data);
        }

        Assert::same($response->getStatusCode(), 201);
    }
}
