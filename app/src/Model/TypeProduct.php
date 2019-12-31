<?php

namespace RecruitingApp\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypeProduct
 * @package RecruitingApp\Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="type_products")
 */
class TypeProduct
{
    use DefaultModelTrait;

    /**
     * @var array $products
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="productType")
     */
    private $products;

    /**
     * @var string $name
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(type="float", name="tax_percentage")
     */
    private $taxPercentage = 0.0;

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getTaxPercentage()
    {
        return $this->taxPercentage;
    }

    /**
     * @param float $taxPercentage
     */
    public function setTaxPercentage($taxPercentage)
    {
        $this->taxPercentage = $taxPercentage;
    }
}