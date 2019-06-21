<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleRepository")
 * @ORM\Table(name="vehicle")
 */
class Vehicle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var integer|null
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string|null
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $seats = 1;

    /**
     * @ORM\Column(name="bought_at", type="date")
     * @var \DateTime|null
     */
    private $boughtAt;

    /**
     * @ORM\Column(name="leased_until", type="date", nullable=true)
     * @var \DateTime|null
     */
    private $leasedUntil;

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string|null $model
     */
    public function setModel(?string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function getSeats(): int
    {
        return $this->seats;
    }

    /**
     * @param int $seats
     */
    public function setSeats(int $seats): void
    {
        $this->seats = $seats;
    }

    /**
     * @return \DateTime|null
     */
    public function getBoughtAt(): ?\DateTime
    {
        return $this->boughtAt;
    }

    /**
     * @param \DateTime $boughtAt
     */
    public function setBoughtAt(?\DateTime $boughtAt): void
    {
        $this->boughtAt = $boughtAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getLeasedUntil(): ?\DateTime
    {
        return $this->leasedUntil;
    }

    /**
     * @param \DateTime|null $leasedUntil
     */
    public function setLeasedUntil(?\DateTime $leasedUntil): void
    {
        $this->leasedUntil = $leasedUntil;
    }
}
