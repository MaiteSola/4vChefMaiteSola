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

    #[Assert\NotBlank(message: "La cantidad es obligatoria")]
    // 1. Validamos que sea numérico (acepta "10", "10.5", 10, 10.5)
    #[Assert\Type(type: 'numeric', message: "La cantidad debe ser un valor numérico.")]
    // 2. Validamos que sea positivo (opcional pero recomendado)
    #[Assert\Positive(message: "La cantidad debe ser mayor a 0")]
    #[SerializedName('quantity')]
    public mixed $cantidad;

    #[Assert\NotBlank(message: "La unidad es obligatoria")]
    #[SerializedName('unit')]
    public string $unidad;
}
