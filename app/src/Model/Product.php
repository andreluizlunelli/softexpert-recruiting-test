<?php

namespace RecruitingApp\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package RecruitingApp\Model
 *
 * @ORM\Entity(repositoryClass="RecruitingApp\Repository\ProductRepository")
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks
 */
class Product implements \JsonSerializable
{
    use DefaultModelTrait, DateFormat;

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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt= new \DateTime();
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => [
                'id' => $this->productType->getId(),
                'name' => $this->productType->getName(),
                'tax_percentage' => $this->productType->getTaxPercentage()
            ],
            'created_at' => $this->formatDateView($this->createdAt),
            'updated_at' => $this->formatDateView($this->updatedAt)
        ];
    }
}