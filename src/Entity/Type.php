<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=ProductDetails::class, mappedBy="type")
     */
    private $productDetails;

    public function __construct()
    {
        $this->productDetails = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString() 
    {
        return $this->getTitle();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, ProductDetails>
     */
    public function getProductDetails(): Collection
    {
        return $this->productDetails;
    }

    public function addProductDetail(ProductDetails $productDetail): self
    {
        if (!$this->productDetails->contains($productDetail)) {
            $this->productDetails[] = $productDetail;
            $productDetail->setType($this);
        }

        return $this;
    }

    public function removeProductDetail(ProductDetails $productDetail): self
    {
        if ($this->productDetails->removeElement($productDetail)) {
            // set the owning side to null (unless already changed)
            if ($productDetail->getType() === $this) {
                $productDetail->setType(null);
            }
        }

        return $this;
    }


    
}
