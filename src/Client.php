<?php

namespace Hussainweb\DrupalApi;

use Hussainweb\DrupalApi\Entity\Collection\EntityCollection;
use Hussainweb\DrupalApi\Entity\Entity;
use Hussainweb\DrupalApi\Request\Request;
use Psr\Http\Client\ClientInterface;

class Client
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    public function __construct(ClientInterface $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Send an API request and wrap it in the corresponding Entity object.
     *
     * @param Request $request
     *   The request to send.
     *
     * @return Entity|EntityCollection
     *   The entity or the collection for the request.
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getEntity(Request $request)
    {
        $response = $this->httpClient->sendRequest($request);
        $entity_class = $request->getEntityClass();
        return $entity_class::fromResponse($response);
    }
}
