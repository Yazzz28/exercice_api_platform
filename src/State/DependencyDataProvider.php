<?php

namespace App\State;

use App\Entity\Dependency;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

class DependencyDataProvider implements ProviderInterface
{

    public function __construct(private string $rootPath)
    {

    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere
    
        // Return a default value
        return null;
    }

    public function getCollection(string $ressourceClass, string $operationName, array $context = [])
    {
        $path = $this->rootPath . 'composer.json';
        $json = json_decode(file_get_contents($path), true);
        dd($json);
    }

    public function supports(string $ressourceClass, string $operationName, array $context = []): bool
    {
        return $ressourceClass === Dependency::class;
    }
}
