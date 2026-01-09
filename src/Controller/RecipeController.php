<?php

namespace App\Controller;

use App\DTO\CrearRecetaDto;
use App\Entity\Ingrediente;
use App\Entity\Paso;
use App\Entity\Receta;
use App\Entity\RecetaNutriente;
use App\Repository\RecetaRepository;
use App\Repository\TipoNutrienteRepository;
use App\Repository\TipoRecetaRepository;
use App\Repository\ValoracionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Valoracion;


#[Route('/recipes', name: 'api_recipes_')]
class RecipeController extends AbstractController
{
    // =========================================================================
    // GET /recipes - Listar recetas (con filtro opcional por tipo)
    // =========================================================================
    #[Route('', name: 'list', methods: ['GET'])]
    public function searchRecipes(
        RecetaRepository $recetaRepo,
        Request $request,
        TipoRecetaRepository $tipoRepo
    ): JsonResponse {
        // Parámetro de query 'type' según el YAML
        $typeId = $request->query->get('type');

        if ($typeId) {
            $tipo = $tipoRepo->find($typeId);
            if (!$tipo) {
                return $this->json(['code' => 400, 'description' => 'Tipo de receta no encontrado'], 400);
            }

            $recetas = $recetaRepo->findBy([
                'deletedAt' => null,
                'tipo' => $tipo
            ]);
        } else {
            $recetas = $recetaRepo->findBy(['deletedAt' => null]);
        }

        return $this->json($recetas, 200, [], ['groups' => 'receta:leer']);
    }

    // =========================================================================
    // POST /recipes - Crear nueva receta
    // =========================================================================
    #[Route('', name: 'create', methods: ['POST'])]
    public function newRecipe(
        #[MapRequestPayload] CrearRecetaDto $dto,
        TipoRecetaRepository $tipoRepo,
        TipoNutrienteRepository $nutrienteRepo,
        EntityManagerInterface $em
    ): JsonResponse {
        // Validar que el tipo de receta existe
        $tipo = $tipoRepo->find($dto->tipoId);
        if (!$tipo) {
            return $this->json(['code' => 400, 'description' => "El tipo de receta con ID {$dto->tipoId} no existe."], 400);
        }

        // Crear la receta
        $receta = new Receta();
        $receta->setTitulo($dto->titulo);
        $receta->setComensales($dto->comensales);
        $receta->setTipo($tipo);

        // Añadir ingredientes
        foreach ($dto->ingredientes as $ingDto) {
            $ingrediente = new Ingrediente();
            $ingrediente->setNombre($ingDto->nombre);
            $ingrediente->setCantidad($ingDto->cantidad);
            $ingrediente->setUnidad($ingDto->unidad);
            $receta->addIngrediente($ingrediente);
        }

        // Añadir pasos
        foreach ($dto->pasos as $pasoDto) {
            $paso = new Paso();
            $paso->setOrden($pasoDto->orden);
            $paso->setDescripcion($pasoDto->descripcion);
            $receta->addPaso($paso);
        }

        // Añadir nutrientes
        foreach ($dto->nutrientes as $nutDto) {
            $tipoNutriente = $nutrienteRepo->find($nutDto->tipoId);
            if ($tipoNutriente) {
                $recetaNutriente = new RecetaNutriente();
                $recetaNutriente->setCantidad($nutDto->cantidad);
                $recetaNutriente->setTipoNutriente($tipoNutriente);
                $receta->addRecetaNutriente($recetaNutriente);
            }
        }

        $em->persist($receta);
        $em->flush();

        return $this->json($receta, 200, [], ['groups' => 'receta:leer']);
    }

    // =========================================================================
    // POST /recipes/{recipeId}/rating/{rate} - Valorar receta
    // =========================================================================
    #[Route('/{recipeId}/rating/{rate}', name: 'rate', methods: ['POST'])]
    public function uploadRating(
        int $recipeId,
        int $rate,
        RecetaRepository $recetaRepo,
        ValoracionRepository $valoracionRepo,
        EntityManagerInterface $em,
        Request $request
    ): JsonResponse {
        // Validar que la puntuación esté entre 0 y 5
        if ($rate < 0 || $rate > 5) {
            return $this->json(['code' => 400, 'description' => 'La puntuación debe estar entre 0 y 5'], 400);
        }

        // Buscar la receta
        $receta = $recetaRepo->find($recipeId);
        if (!$receta || $receta->getDeletedAt() !== null) {
            return $this->json(['code' => 400, 'description' => 'Receta no encontrada'], 400);
        }

        // Obtener IP
        $ipCliente = $request->getClientIp() ?? 'unknown';

        // Verificar si ya votó
        $votoExistente = $valoracionRepo->findOneBy([
            'receta' => $receta,
            'ip' => $ipCliente
        ]);

        if ($votoExistente) {
            return $this->json(['code' => 400, 'description' => 'Ya has valorado esta receta'], 400);
        }

        // Crear valoración
        $valoracion = new Valoracion();
        $valoracion->setPuntuacion($rate);
        $valoracion->setIp($ipCliente);
        $valoracion->setReceta($receta);

        $em->persist($valoracion);
        $em->flush();

        return $this->json($receta, 200, [], ['groups' => 'receta:leer']);
    }

    // =========================================================================
    // DELETE /recipes/{recipeId} - Borrar receta (soft delete)
    // =========================================================================
    #[Route('/{recipeId}', name: 'delete', methods: ['DELETE'])]
    public function deleteRecipe(
        int $recipeId,
        RecetaRepository $recetaRepo,
        EntityManagerInterface $em
    ): JsonResponse {
        $receta = $recetaRepo->find($recipeId);

        if (!$receta || $receta->getDeletedAt() !== null) {
            return $this->json(['code' => 400, 'description' => 'Receta no encontrada o ya eliminada'], 400);
        }

        $receta->setDeletedAt(new \DateTimeImmutable());
        $em->flush();

        return $this->json($receta, 200, [], ['groups' => 'receta:leer']);
    }
}
