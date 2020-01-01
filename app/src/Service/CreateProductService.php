<?php

namespace RecruitingApp\Service;

use RecruitingApp\Api\Exception\ApiException;
use RecruitingApp\Model\Product;
use RecruitingApp\Model\TypeProduct;
use RecruitingApp\Repository\TypeProductRepository;

class CreateProductService
{
    use EntityManagerOnService;

    /**
     * @param array $params
     *
     * @return Product
     *
     * @throws ApiException
     */
    public function create($params)
    {
        /** @var TypeProductRepository $repositoryTypeProduct */
        $repositoryTypeProduct = $this->entityManager->getRepository(TypeProduct::class);

        $typeCode = array_key_exists('type', $params)
            ? $params['type']
            : null;

        /** @var TypeProduct $typeProduct */
        $typeProduct = $repositoryTypeProduct->findOneByCode($typeCode);

        if (is_null($typeProduct)) {
            throw new ApiException('Não foi encontrado o tipo do produto');
        }

        if (! array_key_exists('name', $params)) {
            throw new ApiException('Necessário informar o campo: name');
        }

        if (! array_key_exists('description', $params)) {
            throw new ApiException('Necessário informar o campo: description');
        }

        $product = new Product();
        $product->setName($params['name']);
        $product->setDescription($params['description']);
        $product->setProductType($typeProduct);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}