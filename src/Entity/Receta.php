<?php

namespace App\Entity;

use App\Repository\RecetaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetaRepository::class)]
class Receta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titulo = null;

    #[ORM\Column]
    private ?int $comensales = null;

    // Relación ManyToOne con TipoReceta
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoReceta $tipo = null;

    // Las relaciones inversas (ingredientes, pasos, etc.) se generan solas al regenerar

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getComensales(): ?int
    {
        return $this->comensales;
    }

    public function setComensales(int $comensales): static
    {
        $this->comensales = $comensales;

        return $this;
    }

    public function getTipo(): ?TipoReceta
    {
        return $this->tipo;
    }

    public function setTipo(?TipoReceta $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }
}