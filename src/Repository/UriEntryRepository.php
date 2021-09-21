<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UriEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UriEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method UriEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method UriEntry[]    findAll()
 * @method UriEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UriEntryRepository extends ServiceEntityRepository
{
    /**
     * UriEntryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UriEntry::class);
    }
}
