<?php

namespace App\State;

use App\Entity\Dependency;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\DependencyRepository;

class DependencyDataPersister implements ProcessorInterface
{

    public function __construct(private DependencyRepository $repository)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        // Handle the state
    }

    public function supports(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $data instanceof Dependency;
    }

    public function persist(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->repository->persist($data);
    }

    public function remove(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        // Remove the state
    }
}
