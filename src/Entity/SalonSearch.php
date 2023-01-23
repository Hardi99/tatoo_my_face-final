<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SalonSearch {

    /**
     * @var ArrayCollection 
     */
    private $tatoo_style;

    /**
     * @var integer|null
     */
    private $distance;

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var float|null
     */
    private $lng;

    public function __construct()
    {
        $this->tatoo_style = new ArrayCollection();
    }

    /**
     * @return Arrayollection $tatoo_styles
     */
    public function getTatooStyles(): ArrayCollection
    {
        return $this->tatoo_style;
    }

    /**
     * @param ArrayCollection $tatoo_styles
     */
    public function setTatooStyles(ArrayCollection $tatoo_style): void
    {
        $this->tatoo_style = $tatoo_style;
    }

    /**
     * @return int|null
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     * @param int|null $distance
     * @return SalonSearch
     */
    public function setDistance(?int $distance): SalonSearch
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     * @return SalonSearch
     */
    public function setLat(?float $lat): SalonSearch
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float|null $lng
     * @return SalonSearch
     */
    public function setLng(?float $lng): SalonSearch
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     * @return SalonSearch
     */
    public function setAddress(?string $address): SalonSearch
    {
        $this->address = $address;
        return $this;
    }
}