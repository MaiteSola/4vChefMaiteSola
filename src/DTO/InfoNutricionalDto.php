<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class InfoNutricionalDto
{
    #[Assert\NotBlank(message: "El tipo de nutriente es obligatorio")]
    #[SerializedName('type-id')]
    public int $tipoId; // El ID del nutriente (ej: 1 para Proteínas)

    #[Assert\NotBlank(message: "La cantidad es obligatoria")]
    #[Assert\Type(type: 'float', message: "La cantidad debe ser un número decimal.")]
    #[Assert\Positive(message: "La cantidad debe ser positiva")]
    #[SerializedName('quantity')]
    public float $cantidad; // Ej: 10.5
}
