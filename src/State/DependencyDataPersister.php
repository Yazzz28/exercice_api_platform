<?php

namespace App\State;

use App\Entity\Dependency;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\DependencyRepository;
use ApiPlatform\Metadata\DeleteOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class DependencyDataPersister implements ProcessorInterface
{
    public function __construct(
        private DependencyRepository $repository
    ) {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if ($operation instanceof DeleteOperationInterface) {
            $this->remove($data);
            return;
        }

        $this->persist($data);
    }

    public function remove(Dependency $dependency): void
    {
        $this->repository->remove($dependency);
    }

    public function persist(Dependency $dependency): void
    {
        $this->repository->persist($dependency);
    }
}
