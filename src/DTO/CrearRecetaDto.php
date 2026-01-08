<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class CrearRecetaDto
{
    #[Assert\NotBlank(message: "El título es obligatorio")]
    #[Assert\Length(min: 3, max: 100, minMessage: "El título es muy corto", maxMessage: "El título es muy largo")]
    #[Assert\Type(type: 'string', message: "El título debe ser un texto.")]
    #[SerializedName('title')]
    public mixed $titulo;

    #[Assert\NotBlank]
    #[Assert\Positive(message: "Debe haber al menos 1 comensal")]
    #[SerializedName('number-diner')]
    public int $comensales;

    // El frontend nos enviará el ID del tipo (ej: 1 para "Postre")
    #[Assert\NotBlank(message: "Debes seleccionar un tipo de receta")]
    #[SerializedName('type-id')]
    public int $tipoId;

    /** @var IngredienteDto[] */
    #[Assert\Count(min: 1, minMessage: "La receta debe tener al menos 1 ingrediente")]
    #[Assert\Valid] // <--- IMPORTANTE: Valida que cada ingrediente de la lista esté bien
    #[SerializedName('ingredients')]
    public array $ingredientes = [];

    /** @var PasoDto[] */
    #[Assert\Count(min: 1, minMessage: "La receta debe tener al menos 1 paso")]
    #[Assert\Valid] // <--- IMPORTANTE: Valida cada paso de la lista
    #[SerializedName('steps')]
    public array $pasos = [];

    /** @var InfoNutricionalDto[] */
    #[Assert\Valid] // Valida cada objetito de la lista
    #[SerializedName('nutrients')]
    public array $nutrientes = [];
}
