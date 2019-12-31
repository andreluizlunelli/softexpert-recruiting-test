<?php

namespace RecruitingApp\Model;

use Doctrine\ORM\Mapping as ORM;

trait DefaultModelTrait
{
    /**
     * @var int $id
     *
     * @ORM\Id()
     */
    protected $id;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    protected $updatedAt;

}