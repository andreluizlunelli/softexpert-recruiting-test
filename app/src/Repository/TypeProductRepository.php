<?php

namespace RecruitingApp\Repository;

use Doctrine\ORM\EntityRepository;
use RecruitingApp\Model\TypeProduct;

class TypeProductRepository extends EntityRepository
{
    public function findOneByCode($codeId)
    {
        if (! empty($codeId)) {
            return $this->find($codeId);
        }

        $typeProduct = $this->findOneBy(['name' => TypeProduct::TAX_FREE]);

        if (empty($typeProduct)) {
            $typeProduct = new TypeProduct();
            $typeProduct->setName(TypeProduct::TAX_FREE);
            $typeProduct->setTaxPercentage(0);
            $this->_em->persist($typeProduct);
            $this->_em->flush();
        }

        return $typeProduct;
    }
}