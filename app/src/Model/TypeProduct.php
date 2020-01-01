<?php

namespace RecruitingApp\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypeProduct
 * @package RecruitingApp\Model
 *
 * @ORM\Entity(repositoryClass="RecruitingApp\Repository\TypeProductRepository")
 * @ORM\Table(name="type_products")
 * @ORM\HasLifecycleCallbacks
 */
class TypeProduct implements \JsonSerializable
{
    use DefaultModelTrait, DateFormat;

    const TAX_FREE = 'livre de impostos';

    /**
     * @var ArrayCollection $products
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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->products = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
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
            'tax_percentage' => $this->taxPercentage,
            'created_at' => $this->formatDateView($this->createdAt),
            'updated_at' => $this->formatDateView($this->updatedAt)
        ];
    }
}