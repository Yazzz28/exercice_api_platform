<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use Ramsey\Uuid\Uuid;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\State\DependencyDataProvider;
use App\State\DependencyDataPersister;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as PostMethod;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new PostMethod(
            processor: DependencyDataPersister::class
        ),
        new Patch(
            denormalizationContext: [
                'groups' => ['put:Dependency']
            ]
        ),
        new Delete()
    ],
    paginationEnabled: false,
    provider: DependencyDataProvider::class,
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
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 3,
        max: 255
    )]
    private string $name;
    #[ApiProperty(
        description: 'The version of the dependency',
        example: '1.0.0'
    )]
    #[Assert\NotBlank()]
    #[Assert\Regex(
        pattern: '/^\d+\.\d+\.\d+$/',
        message: 'The version must be in the format x.x.x'
    )]
    #[Groups(['put:Dependency'])]
    private string $version;

    public function __construct(
        string $name,
        string $version,
    ) {
        $this->uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
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


    /**
     * Set the value of version
     *
     * @return  self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }
}
