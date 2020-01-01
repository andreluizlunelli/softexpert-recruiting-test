<?php

namespace RecruitingApp\Service;

use RecruitingApp\Api\Exception\ApiException;
use RecruitingApp\Model\Product;
use RecruitingApp\Model\TypeProduct;

class AddProductOnTypeService
{
    use EntityManagerOnService;

    /**
     * @param int $idTypeProduct
     * @param int $idProduct
     *
     * @return void
     *
     * @throws ApiException
     */
    public function add($idTypeProduct, $idProduct)
    {
        if (empty($idTypeProduct) || empty($idProduct)) {
            throw new ApiException('Necessário informar os campos: id-type e id-product');
        }

        $repositoryType = $this->entityManager->getRepository(TypeProduct::class);

        /** @var TypeProduct $typeProduct */
        $typeProduct = $repositoryType->find($idTypeProduct);

        if (is_null($typeProduct)) {
            throw new ApiException('Não foi possível encontrar o tipo de produto: ' . $idTypeProduct);
        }

        $repositoryProduct = $this->entityManager->getRepository(Product::class);

        /** @var Product $product */
        $product = $repositoryProduct->find($idProduct);

        $product->setProductType($typeProduct);

        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}