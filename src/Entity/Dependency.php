<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\State\DependencyDataProvider;
use ApiPlatform\Metadata\GetCollection;


#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ],
    paginationEnabled: false,
    provider: DependencyDataProvider::class
    )]
class Dependency
{
#[ApiProperty(
    identifier: true
)]
    private string $uuid;
    #[ApiProperty(
        description: 'The name of the dependency'
    )]
    private string $name;
    #[ApiProperty(
        description: 'The version of the dependency',
        example: '1.0.0'
    )]
    private string $version;

    public function __construct(
        string $uuid,
        string $name,
        string $version,
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->version = $version;
    }



    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of version
     */ 
    public function getVersion()
    {
        return $this->version;
    }
}
