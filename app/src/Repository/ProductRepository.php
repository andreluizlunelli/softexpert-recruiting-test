<?php

namespace RecruitingApp\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @param string $like
     *
     * @return array
     */
    public function findByNameLike($like)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder
            ->where('p.name LIKE :search')
            ->orWhere('p.description LIKE :search')
            ->setParameter('search', "%$like%")
            ->getQuery()
            ->getResult();
    }
}