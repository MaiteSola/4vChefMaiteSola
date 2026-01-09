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
    #[Assert\Type(type: 'float', message: "La cantidad debe ser un número decimal.")]
    #[Assert\Positive(message: "La cantidad debe ser mayor a 0")]
    #[SerializedName('quantity')]
    public float $cantidad;

    #[Assert\NotBlank(message: "La unidad es obligatoria")]
    #[SerializedName('unit')]
    public string $unidad;
}
