<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class IngredienteDto
{
    #[Assert\NotBlank(message: "El nombre del ingrediente es obligatorio")]
    #[SerializedName('name')]
    public string $nombre;

    #[Assert\NotBlank(message: "La cantidad es obligatoria")]
    #[SerializedName('quantity')]
    public string $cantidad;

    #[Assert\NotBlank(message: "La unidad es obligatoria")]
    #[SerializedName('unit')]
    public string $unidad;
}
