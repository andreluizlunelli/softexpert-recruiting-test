<?php

namespace RecruitingApp\Service;

use Doctrine\ORM\EntityManager;
use RecruitingApp\Model\Product;

class DeleteProductService
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * ProductController constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function delete($id)
    {
        $repository = $this->entityManager->getRepository(Product::class);

        $product = $repository->find($id);

        if (is_null($product)) {
            return;
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}