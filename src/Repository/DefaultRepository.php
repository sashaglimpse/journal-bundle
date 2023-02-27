<?php

namespace MyTv\JournalBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class DefaultRepository.
 *
 * @template TEntityClass of object
 * @extends ServiceEntityRepository<TEntityClass>
 */
abstract class DefaultRepository extends ServiceEntityRepository
{
    public const DEFAULT_ALIAS = 'root';

    public function createListQueryBuilder(array $filters, array $sort = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder(self::DEFAULT_ALIAS);

        $this->applyFilters($queryBuilder, $filters, self::DEFAULT_ALIAS);
        $this->applySort($queryBuilder, $sort, self::DEFAULT_ALIAS);

        return $queryBuilder;
    }

    protected function applyFilters(QueryBuilder $queryBuilder, array $filters, string $alias): void
    {
        foreach ($filters as $field => $value) {
            if (null === $value || '' === $value) {
                continue;
            }

            if (is_array($value)) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->in("{$alias}.{$field}", ":filter_{$field}"))
                    ->setParameter("filter_{$field}", $value)
                ;
            } else {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq("{$alias}.{$field}", ":filter_{$field}"))
                    ->setParameter("filter_{$field}", $value)
                ;
            }
        }
    }

    protected function applySort(QueryBuilder $queryBuilder, array $sort, string $alias): void
    {
        foreach ($sort as $field => $order) {
            $queryBuilder->addOrderBy($field, $order);
        }
    }
}
