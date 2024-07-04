<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\PublishPostAction;;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\CountPostController;
use ApiPlatform\Metadata\Post as PostMethod;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    operations: [
        new PostMethod(
            name: 'publish',
            uriTemplate: '/posts/{id}/publish',
            controller: PublishPostAction::class,
        ),
        new Get(
            normalizationContext: ['groups' => ['read:Posts']],
            name: 'count_posts',
            uriTemplate: '/posts/count',
            controller: CountPostController::class,
            read: false,
            openapiContext: [
                'summary' => 'Counts the number of posts',
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'online',
                        'schema' => [
                            'type' => 'integer',
                            'default' => 1,
                            'minimum' => 0,
                            'maximum' => 1,
                        ],
                        'description' => 'Filters the posts',
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => 'The total number of posts',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'integer',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        )
    ]
)]
#[Get(
    normalizationContext: ['groups' => ['read:Post']],
)]
#[GetCollection(
    normalizationContext: ['groups' => ['read:Posts']],
)]
#[PostMethod(
    denormalizationContext: ['groups' => ['write:Post']],
)]
#[Put]
#[Delete]

class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Posts', 'read:Post', 'write:Post'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Posts', 'read:Post', 'write:Post'])]
    #[Assert\NotBlank]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:Post', 'write:Post'])]
    #[Assert\Length(min: 5)]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['read:Post'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read:Post'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'posts', cascade: ['persist'])]
    #[Groups(['read:Posts', 'read:Post', 'write:Post'])]
    #[Valid]
    private ?Category $category = null;

    #[ORM\Column]
    #[Groups(['read:Posts', 'read:Post', 'write:Post'])]
    private ?bool $online = false;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): static
    {
        $this->online = $online;

        return $this;
    }
}
