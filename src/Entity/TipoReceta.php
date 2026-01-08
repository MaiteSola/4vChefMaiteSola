<?php

namespace App\Entity;

use App\Repository\TipoRecetaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TipoRecetaRepository::class)]
class TipoReceta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['receta:leer', 'tipo:leer'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['receta:leer', 'tipo:leer'])]
    #[SerializedName('name')]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['receta:leer', 'tipo:leer'])]
    #[SerializedName('description')]
    private ?string $descripcion = null;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
