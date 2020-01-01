<?php

namespace RecruitingApp\Service;

use Doctrine\ORM\EntityManager;

trait EntityManagerOnService
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * ProductController constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}