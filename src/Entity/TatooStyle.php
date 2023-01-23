<?php

namespace App\Entity;

use App\Repository\TatooStyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TatooStyleRepository::class)
 */
class TatooStyle
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Salon::class, mappedBy="tatoo_style")
     * @ORM\JoinColumn(name="salon_id", referencedColumnName="id")
     */
    private $salon;

    public function __construct()
    {
        $this->salon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Salon>
     */
    public function getSalon(): Collection
    {
        return $this->salon;
    }

    public function addSalon(Salon $salon): self
    {
        if (!$this->salon->contains($salon)) {
            $this->salon[] = $salon;
        }

        return $this;
    }

    public function removeSalon(Salon $salon): self
    {
        $this->salon->removeElement($salon);

        return $this;
    }
}
