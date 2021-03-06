<?php

namespace RecruitingApp\Service;

use RecruitingApp\Api\Exception\ApiException;
use RecruitingApp\Model\TypeProduct;

class CreateTypeProductService
{
    use EntityManagerOnService;

    /**
     * @param array $params
     *
     * @return TypeProduct
     *
     * @throws ApiException
     */

    public function create($params)
    {
        if (! array_key_exists('name', $params)) {
            throw new ApiException('Necessário informar o campo: name');
        }

        if (! array_key_exists('tax_percentage', $params)) {
            throw new ApiException('Necessário informar o campo: tax_percentage');
        }

        $typeProduct = new TypeProduct();
        $typeProduct->setName($params['name']);
        $typeProduct->setTaxPercentage($params['tax_percentage']);

        $this->entityManager->persist($typeProduct);
        $this->entityManager->flush();

        return $typeProduct;
    }
}