<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: OrderPayment::class, mappedBy: 'orderData', orphanRemoval: true)]
    private Collection $orderPayments;

    public function __construct()
    {
        $this->orderPayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, OrderPayment>
     */
    public function getOrderPayments(): Collection
    {
        return $this->orderPayments;
    }

    public function addOrderPayment(OrderPayment $orderPayment): static
    {
        if (!$this->orderPayments->contains($orderPayment)) {
            $this->orderPayments->add($orderPayment);
            $orderPayment->setOrderData($this);
        }

        return $this;
    }

    public function removeOrderPayment(OrderPayment $orderPayment): static
    {
        if ($this->orderPayments->removeElement($orderPayment)) {
            // set the owning side to null (unless already changed)
            if ($orderPayment->getOrderData() === $this) {
                $orderPayment->setOrderData(null);
            }
        }

        return $this;
    }
}
