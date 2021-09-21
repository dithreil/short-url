<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UriEntryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UriEntryRepository::class)
 * @ORM\Table(name="uri_entries")
 */
class UriEntry
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="long_uri", type="string")
     */
    private string $longUri;

    /**
     * @var string
     * @ORM\Column(name="short_uri", type="string")
     */
    private string $shortUri;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="expire_time", type="datetime_immutable")
     */
    private \DateTimeImmutable $expireTime;

    /**
     * UriEntry constructor.
     * @param string $longUri
     * @param string $shortUri
     */
    public function __construct(string $longUri, string $shortUri)
    {
        $this->longUri = $longUri;
        $this->shortUri = $shortUri;
        $this->expireTime = new \DateTimeImmutable('tomorrow', new \DateTimeZone('Europe/Moscow'));
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getShortUri(): string
    {
        return $this->shortUri;
    }

    /**
     * @param string $shortUri
     */
    public function setShortUri(string $shortUri): void
    {
        $this->shortUri = $shortUri;
    }

    /**
     * @return string
     */
    public function getLongUri(): string
    {
        return $this->longUri;
    }

    /**
     * @param string $longUri
     */
    public function setLongUri(string $longUri): void
    {
        $this->longUri = $longUri;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getExpireTime(): \DateTimeImmutable
    {
        return $this->expireTime;
    }

    public function setExpireTime(): void
    {
        $this->expireTime = new \DateTimeImmutable('tomorrow', new \DateTimeZone('Europe/Moscow'));
    }
}
