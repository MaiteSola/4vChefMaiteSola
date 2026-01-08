<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class PasoDto
{
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[SerializedName('order')]
    public int $orden;

    #[Assert\NotBlank(message: "La descripción del paso es obligatoria")]
    #[SerializedName('description')]
    public string $descripcion;
}
