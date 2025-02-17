<?php

namespace App\Repository;

use Ramsey\Uuid\Uuid;
use App\Entity\Dependency;

class DependencyRepository
{
    public function __construct(private string $rootPath)
    {
    }

    private function getDependencies(): array
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        return $json['require'];
    }

    public function findAll(): array
    {
        $items = [];
        foreach ($this->getDependencies() as $name => $version) {
            $items[] = new Dependency($name, $version);
        }
        return $items;
    }

    public function findOneBy(string $uuid): ?Dependency
    {
        foreach ($this->findAll() as $dependency) {
            if ($dependency->getUuid() === $uuid) {
                return new Dependency($dependency->getName(), $dependency->getVersion());
            }
        }
        return null;
    }

    public function persist(Dependency $dependency): void
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        $json['require'][$dependency->getName()] = $dependency->getVersion();
        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
    

    public function remove(Dependency $dependency): void
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        unset($json['require'][$dependency->getName()]);
        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT));
    }
}