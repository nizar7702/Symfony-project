<?php

namespace App\Entity;

use App\Repository\Product2Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Product2Repository::class)
 */
class Product2
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lib;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $im;

    /**
     * @ORM\Column(type="float")
     */
    private $pru;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLib(): ?string
    {
        return $this->lib;
    }

    public function setLib(string $lib): self
    {
        $this->lib = $lib;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIm(): ?string
    {
        return $this->im;
    }

    public function setIm(string $im): self
    {
        $this->im = $im;

        return $this;
    }

    public function getPru(): ?float
    {
        return $this->pru;
    }

    public function setPru(float $pru): self
    {
        $this->pru = $pru;

        return $this;
    }
}
