<?php

namespace App\Entity;

use App\Repository\IngredienteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: IngredienteRepository::class)]
class Ingrediente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['receta:leer'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['receta:leer'])]
    #[SerializedName('name')]
    private ?string $nombre = null;

    #[ORM\Column(length: 50)]
    #[Groups(['receta:leer'])]
    #[SerializedName('quantity')]
    private ?string $cantidad = null;

    #[ORM\Column(length: 20)]
    #[Groups(['receta:leer'])]
    #[SerializedName('unit')]
    private ?string $unidad = null; // Ej: pizcas, ml

    #[ORM\ManyToOne(inversedBy: 'ingredientes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Receta $receta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCantidad(): ?string
    {
        return $this->cantidad;
    }

    public function setCantidad(string $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    public function setUnidad(string $unidad): static
    {
        $this->unidad = $unidad;

        return $this;
    }

    public function getReceta(): ?Receta
    {
        return $this->receta;
    }

    public function setReceta(?Receta $receta): static
    {
        $this->receta = $receta;

        return $this;
    }
}
