<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class InfoNutricionalDto
{
    #[Assert\NotBlank]
    #[SerializedName('type-id')]
    public int $tipoId; // El ID del nutriente (ej: 1 para Proteínas)

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[SerializedName('quantity')]
    public float $cantidad; // Ej: 10.5
}
