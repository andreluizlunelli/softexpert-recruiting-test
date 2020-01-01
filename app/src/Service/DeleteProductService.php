<?php

namespace RecruitingApp\Service;

use RecruitingApp\Model\Product;

class DeleteProductService
{
    use EntityManagerOnService;

    /**
     * @param int $id
     */
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