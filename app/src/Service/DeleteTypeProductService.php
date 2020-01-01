<?php

namespace RecruitingApp\Service;

use RecruitingApp\Api\Exception\ApiException;
use RecruitingApp\Model\TypeProduct;

class DeleteTypeProductService
{
    use EntityManagerOnService;

    public function delete($id)
    {
        $repository = $this->entityManager->getRepository(TypeProduct::class);

        /** @var TypeProduct $typeProduct */
        $typeProduct = $repository->find($id);

        if (is_null($typeProduct)) {
            return;
        }

        if ($typeProduct->getProducts()->count() > 0) {
            throw new ApiException('Não é possível excluir um tipo de produto com produtos associados');
        }

        $this->entityManager->remove($typeProduct);
        $this->entityManager->flush();
    }
}