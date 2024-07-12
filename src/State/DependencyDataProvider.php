<?php

namespace App\State;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Dependency;
use Ramsey\Uuid\Uuid;
use App\Repository\DependencyRepository;

final class DependencyDataProvider implements ProviderInterface
{
    public function __construct(private DependencyRepository $repository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection) {
            return $this->repository->findAll();
        }
    
        if ($operation instanceof Get) {
            return $this->repository->findOneBy($uriVariables['uuid']);
        }
    
        // Add a default return statement
        return null;
    }
}
