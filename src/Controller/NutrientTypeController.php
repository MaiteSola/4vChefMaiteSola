<?php

namespace App\Controller;

use App\Repository\TipoNutrienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/nutrient-types', name: 'api_nutrient_types_')]
class NutrientTypeController extends AbstractController
{
    // =========================================================================
    // GET /nutrient-types - Listar tipos de nutrientes
    // =========================================================================
    #[Route('', name: 'list', methods: ['GET'])]
    public function searchNutrients(TipoNutrienteRepository $nutrienteRepo): JsonResponse
    {
        $nutrientes = $nutrienteRepo->findAll();

        return $this->json($nutrientes, 200, [], ['groups' => 'nutriente:leer']);
    }
}
