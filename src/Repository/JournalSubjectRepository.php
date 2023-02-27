<?php

namespace MyTv\JournalBundle\Repository;

use MyTv\JournalBundle\Entity\Journal\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of Subject
 * @extends ServiceEntityRepository<Subject>
 */
class JournalSubjectRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subject::class);
    }
}
