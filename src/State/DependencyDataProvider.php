<?php

namespace App\State;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Dependency;
use Ramsey\Uuid\Uuid;

final class DependencyDataProvider implements ProviderInterface
{
    public function __construct(private readonly string $rootPath)
    {

}

public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
{
    $dependencies = $this->_readDependencies();
    if ($operation instanceof GetCollection) {
        $items = [];
        foreach ($dependencies as $name => $version) {
            $items[] = new Dependency(Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString(), $name, $version);
        }
        return $items;
    }


    if ($operation instanceof Get) {
        foreach ($dependencies as $name => $version) {
            if (($uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString()) === $uriVariables['uuid']) {
                return new Dependency($uuid, $name, $version);
            }
        }
        return null;
    }

}

private function _readDependencies(): array
{
    $json = json_decode(file_get_contents($this->rootPath . '/composer.json'), true);
    return $json['require'];

}
}