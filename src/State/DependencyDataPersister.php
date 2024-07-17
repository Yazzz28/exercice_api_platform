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
        private DependencyRepository $repository,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
    ) {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->repository->persist($data);
    }

    public function supports(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $data instanceof Dependency;
    }

    public function persist(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
    }

    public function remove(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        // Remove the state
    }
}
