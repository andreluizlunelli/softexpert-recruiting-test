<?php

namespace RecruitingApp\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package RecruitingApp\Model
 *
 * @ORM\Entity()
 * @ORM\Table(name="products")
 */
class Product
{
    use DefaultModelTrait;

    /**
     * @var TypeProduct $productType
     *
     * @ORM\ManyToOne(targetEntity="TypeProduct", inversedBy="products")
     */
    private $productType;

    /**
     * @var string $name
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return TypeProduct
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param TypeProduct $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

}