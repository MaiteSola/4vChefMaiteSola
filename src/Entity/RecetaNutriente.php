<?php

namespace App\Entity;

use App\Repository\RecetaNutrienteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: RecetaNutrienteRepository::class)]
class RecetaNutriente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['receta:leer'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['receta:leer'])]
    #[SerializedName('quantity')]
    private ?float $cantidad = null;

    #[ORM\ManyToOne(inversedBy: 'recetaNutrientes')]
    #[ORM\JoinColumn(nullable: false)]
    // SIN GROUPS AQUÍ
    private ?Receta $receta = null;

    // --- CAMBIO PRINCIPAL AQUÍ ---
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['receta:leer'])]
    #[SerializedName('type')]
    private ?TipoNutriente $tipoNutriente = null; // Apunta a la clase correcta

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): static
    {
        $this->cantidad = $cantidad;

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

    // --- GETTERS Y SETTERS ACTUALIZADOS ---
    public function getTipoNutriente(): ?TipoNutriente
    {
        return $this->tipoNutriente;
    }

    public function setTipoNutriente(?TipoNutriente $tipoNutriente): static
    {
        $this->tipoNutriente = $tipoNutriente;

        return $this;
    }
}
