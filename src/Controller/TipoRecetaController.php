<?php

namespace App\Controller;

use App\Repository\TipoRecetaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tipos-receta', name: 'api_tipos_receta_')]
class TipoRecetaController extends AbstractController
{
    #[Route('', name: 'listar', methods: ['GET'])]
    public function listar(TipoRecetaRepository $tipoRepo): JsonResponse
    {
        $tipos = $tipoRepo->findAll();
        
        // Usamos un grupo genérico o devolvemos todo si la entidad es sencilla.
        // Si tienes problemas de referencias circulares aquí, avísame y añadimos #[Groups] en TipoReceta.
        return $this->json($tipos, 200);
    }
}