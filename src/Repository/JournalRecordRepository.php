<?php

namespace MyTv\JournalBundle\Repository;

use MyTv\JournalBundle\Entity\EntityInterface;
use MyTv\JournalBundle\Entity\Journal\Record;
use MyTv\JournalBundle\Model\Common\JournalSubject;
use Doctrine\ORM\Proxy\Proxy;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SystemJournalRepository
 * @package MyTv\JournalBundle\Repository
 * @template TEntityClass of Record
 * @extends DefaultRepository<Record>
 */
class JournalRecordRepository extends DefaultRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    protected function applyFilters(QueryBuilder $queryBuilder, array $filters, string $alias): void
    {
        if (array_key_exists('subject', $filters)) {
            $subject = $filters['subject'];
            unset($filters['subject']);
            $subjectCode = null;
            $entityId = null;

            if ($subject instanceof JournalSubject) {
                $subjectCode = $subject->getSubjectCode();
                $entityId = $subject->getEntityId();
            } elseif ($subject instanceof EntityInterface) {
                $entityId = $subject->getId();
                if ($subject instanceof Proxy) {
                    $subjectCode = get_parent_class($subject);
                } else {
                    $subjectCode = get_class($subject);
                }
            } elseif (is_string($subject)) {
                $subjectCode = $subject;
            }

            $queryBuilder
                ->join("{$alias}.subject", 'subject')
                ->leftJoin("{$alias}.relatedRecords", 'relatedRecord')
                ->leftJoin('relatedRecord.subject', 'relatedSubject')
                ->andWhere(
                    $queryBuilder->expr()->orX(
                        $queryBuilder->expr()->eq('subject.entityName', ':subject_code'),
                        $queryBuilder->expr()->eq('relatedSubject.entityName', ':subject_code')
                    )
                )
                ->setParameter('subject_code', $subjectCode);
            if (null !== $entityId) {
                $queryBuilder
                    ->andWhere(
                        $queryBuilder->expr()->orX(
                            $queryBuilder->expr()->eq("{$alias}.entityId", ':entity_id'),
                            $queryBuilder->expr()->eq('relatedRecord.relatedEntityId', ':entity_id')
                        )
                    )
                    ->setParameter('entity_id', $entityId);
            }
        }

        parent::applyFilters($queryBuilder, $filters, $alias);
    }
}
