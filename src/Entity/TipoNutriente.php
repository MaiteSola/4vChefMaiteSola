<?php

namespace App\Entity;

use App\Repository\TipoNutrienteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TipoNutrienteRepository::class)]
class TipoNutriente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['receta:leer', 'nutriente:leer'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['receta:leer', 'nutriente:leer'])]
    #[SerializedName('name')]
    private ?string $nombre = null;

    #[ORM\Column(length: 20)]
    #[Groups(['receta:leer', 'nutriente:leer'])]
    #[SerializedName('unit')]
    private ?string $unidad = null; // Ej: Gramos, Kcal

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

    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    public function setUnidad(string $unidad): static
    {
        $this->unidad = $unidad;

        return $this;
    }
}
