<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Pusher;

use Setono\EconomicBundle\Client\ClientInterface;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Resolver\EndpointResolverInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class EntityPusher implements EntityPusherInterface
{
    private SerializerInterface $serializer;

    private EndpointResolverInterface $endpointResolver;

    private ClientInterface $client;

    public function __construct(
        SerializerInterface $serializer,
        EndpointResolverInterface $endpointResolver,
        ClientInterface $client
    ) {
        $this->serializer = $serializer;
        $this->endpointResolver = $endpointResolver;
        $this->client = $client;
    }

    public function pushEntity(EconomicAwareInterface $entity): void
    {
        $economicIdentifier = $entity->getEconomicIdentifier();

        if (null === $economicIdentifier) {
            $method = 'post';
            $endpoint = $this->endpointResolver->postSingle($entity);
        } else {
            $method = 'put';
            $endpoint = $this->endpointResolver->putSingle($entity, $economicIdentifier);
        }

        $data = $this->serializer->serialize($entity, 'json', ['groups' => 'setono:economic:push']);

        $this->request($method, $endpoint, $data)->getStatusCode();
    }

    private function request(string $method, string $endpoint, string $data): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $this->client->{$method}($endpoint, $data);

        return $response;
    }
}
