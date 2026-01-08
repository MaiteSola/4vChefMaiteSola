<?php

namespace App\Controller;

use App\Repository\TipoRecetaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe-types', name: 'api_recipe_types_')]
class RecipeTypeController extends AbstractController
{
    // =========================================================================
    // GET /recipe-types - Listar tipos de recetas
    // =========================================================================
    #[Route('', name: 'list', methods: ['GET'])]
    public function searchRecipeTypes(TipoRecetaRepository $tipoRepo): JsonResponse
    {
        $tipos = $tipoRepo->findAll();

        return $this->json($tipos, 200, [], ['groups' => 'tipo:leer']);
    }
}
