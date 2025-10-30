<?php

namespace App\Repository;

use App\Entity\SortedLinkedList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SortedLinkedList>
 */
class SortedLinkedListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SortedLinkedList::class);
    }
}
