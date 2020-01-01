<?php

namespace RecruitingApp\Service;

use RecruitingApp\Api\Exception\ApiException;
use RecruitingApp\Model\TypeProduct;

class UpdateTypeProductService
{
    use EntityManagerOnService;

    /**
     * @param int $id
     * @param array $params
     *
     * @return TypeProduct
     *
     * @throws ApiException
     */
    public function update($id, $params)
    {
        /** @var TypeProduct $typeProduct */
        $typeProduct = $this->entityManager->find(TypeProduct::class, $id);

        if (is_null($typeProduct)) {
            throw new ApiException('Tipo de produto não encontrado.');
        }

        if (array_key_exists('name', $params)) {
            $typeProduct->setName($params['name']);
        }

        if (array_key_exists('tax_percentage', $params)) {
            $typeProduct->setTaxPercentage((float) $params['tax_percentage']);
        }

        $this->entityManager->persist($typeProduct);
        $this->entityManager->flush();

        return $typeProduct;
    }
}