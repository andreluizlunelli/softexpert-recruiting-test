<?php

namespace RecruitingApp\Model;

use Doctrine\ORM\Mapping as ORM;

class Product
{
    use DefaultModelTrait;

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


}