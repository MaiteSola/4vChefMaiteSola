<?php

namespace App\DataFixtures;

use App\Entity\Ingrediente;
use App\Entity\Paso;
use App\Entity\Receta;
use App\Entity\TipoReceta;
use App\Entity\TipoNutriente;
use App\Entity\RecetaNutriente;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ======================================================
        // 1. CATÁLOGOS (TIPOS Y NUTRIENTES)
        // ======================================================

        // --- Tipos de Receta ---
        $tipoPostre = new TipoReceta();
        $tipoPostre->setNombre('Postre');
        $tipoPostre->setDescripcion('Platos dulces para finalizar la comida');
        $manager->persist($tipoPostre);

        $tipoPrincipal = new TipoReceta();
        $tipoPrincipal->setNombre('Plato Principal');
        $tipoPrincipal->setDescripcion('El plato fuerte de la comida, base de la dieta');
        $manager->persist($tipoPrincipal);

        $tipoEntrante = new TipoReceta();
        $tipoEntrante->setNombre('Entrante');
        $tipoEntrante->setDescripcion('Platos ligeros para comenzar o para compartir');
        $manager->persist($tipoEntrante);

        // --- Tipos de Nutriente ---
        $nutriProteina = new TipoNutriente();
        $nutriProteina->setNombre('Proteínas');
        $nutriProteina->setUnidad('gr');
        $manager->persist($nutriProteina);

        $nutriKcal = new TipoNutriente();
        $nutriKcal->setNombre('Energía');
        $nutriKcal->setUnidad('Kcal');
        $manager->persist($nutriKcal);

        $nutriGrasa = new TipoNutriente();
        $nutriGrasa->setNombre('Grasas');
        $nutriGrasa->setUnidad('gr');
        $manager->persist($nutriGrasa);

        $nutriCarbo = new TipoNutriente();
        $nutriCarbo->setNombre('Carbohidratos');
        $nutriCarbo->setUnidad('gr');
        $manager->persist($nutriCarbo);

        // ======================================================
        // 2. CREACIÓN DE RECETAS (Usando función auxiliar)
        // ======================================================

        // RECETA 1: Tiramisú (Postre)
        $this->crearReceta(
            $manager,
            'Tiramisú Clásico',
            4,
            $tipoPostre,
            [ // Ingredientes
                ['Mascarpone', 500, 'gr'],
                ['Café', 200, 'ml'],
                ['Bizcochos', 12, 'unidades'],
                ['Cacao en polvo', 30, 'gr']
            ],
            [ // Pasos
                'Preparar el café fuerte y dejar enfriar.',
                'Batir el mascarpone con el azúcar hasta que esté cremoso.',
                'Mojar los bizcochos en café y montar capas.',
                'Espolvorear cacao por encima y enfriar 4 horas.'
            ],
            [ // Nutrientes
                [$nutriKcal, 450],
                [$nutriGrasa, 25],
                [$nutriCarbo, 40]
            ]
        );

        // RECETA 2: Paella Valenciana (Principal)
        $this->crearReceta(
            $manager,
            'Paella Valenciana',
            6,
            $tipoPrincipal,
            [
                ['Arroz Bomba', 600, 'gr'],
                ['Pollo troceado', 500, 'gr'],
                ['Judía verde', 200, 'gr'],
                ['Azafrán', 1, 'pizca']
            ],
            [
                'Sofreír la carne hasta que esté dorada.',
                'Añadir la verdura y el tomate.',
                'Añadir el agua y dejar cocer 20 minutos.',
                'Echar el arroz y cocinar 18 minutos exactos.'
            ],
            [
                [$nutriKcal, 600],
                [$nutriProteina, 35],
                [$nutriCarbo, 80]
            ]
        );

        // RECETA 3: Gazpacho Andaluz (Entrante)
        $this->crearReceta(
            $manager,
            'Gazpacho Andaluz',
            4,
            $tipoEntrante,
            [
                ['Tomate maduro', 1, 'kg'],
                ['Pimiento verde', 1, 'unidad'],
                ['Pepino', 1, 'unidad'],
                ['Aceite de Oliva', 50, 'ml']
            ],
            [
                'Lavar y trocear todas las verduras.',
                'Triturar todo junto con el aceite y vinagre.',
                'Colar para quitar pieles y pepitas.',
                'Servir muy frío.'
            ],
            [
                [$nutriKcal, 120],
                [$nutriProteina, 2],
                [$nutriGrasa, 10]
            ]
        );

        // RECETA 4: Lentejas con Chorizo (Principal)
        $this->crearReceta(
            $manager,
            'Lentejas de la Abuela',
            4,
            $tipoPrincipal,
            [
                ['Lentejas Pardina', 300, 'gr'],
                ['Chorizo', 100, 'gr'],
                ['Zanahoria', 2, 'unidades'],
                ['Patata', 1, 'unidad']
            ],
            [
                'Poner todos los ingredientes en frío en la olla.',
                'Cubrir de agua y llevar a ebullición.',
                'Cocinar a fuego lento 45 minutos.'
            ],
            [
                [$nutriKcal, 550],
                [$nutriProteina, 25],
                [$nutriGrasa, 20]
            ]
        );

        // RECETA 5: Batido de Proteínas (Postre/Snack)
        $this->crearReceta(
            $manager,
            'Batido Power',
            1,
            $tipoPostre,
            [
                ['Leche desnatada', 300, 'ml'],
                ['Plátano', 1, 'unidad'],
                ['Avena', 30, 'gr']
            ],
            [
                'Pelar el plátano.',
                'Mezclar todo en la batidora.',
                'Batir durante 1 minuto a máxima potencia.'
            ],
            [
                [$nutriKcal, 300],
                [$nutriProteina, 15],
                [$nutriCarbo, 45]
            ]
        );

        // ======================================================
        // 3. RECETA BORRADA (Lógica de Negocio)
        // ======================================================
        $recetaBorrada = new Receta();
        $recetaBorrada->setTitulo('Receta Antigua (Borradas)');
        $recetaBorrada->setComensales(1);
        $recetaBorrada->setTipo($tipoPrincipal);
        $recetaBorrada->setDeletedAt(new \DateTimeImmutable()); // ¡Borrado lógico!

        // Le ponemos un paso aunque esté borrada para que sea válida
        $pasoFantasma = new Paso();
        $pasoFantasma->setOrden(1);
        $pasoFantasma->setDescripcion('Esta receta no debería verse.');
        $recetaBorrada->addPaso($pasoFantasma);

        $manager->persist($recetaBorrada);

        // GUARDAR TODO
        $manager->flush();
    }

    /**
     * Función auxiliar para no repetir código al crear recetas
     */
    private function crearReceta(ObjectManager $manager, string $titulo, int $comensales, TipoReceta $tipo, array $ingredientesData, array $pasosData, array $nutrientesData): void
    {
        $receta = new Receta();
        $receta->setTitulo($titulo);
        $receta->setComensales($comensales);
        $receta->setTipo($tipo);

        // Añadir Ingredientes
        foreach ($ingredientesData as $ingData) {
            $ing = new Ingrediente();
            $ing->setNombre($ingData[0]);
            $ing->setCantidad($ingData[1]);
            $ing->setUnidad($ingData[2]);
            $receta->addIngrediente($ing);
        }

        // Añadir Pasos
        foreach ($pasosData as $index => $desc) {
            $paso = new Paso();
            $paso->setOrden($index + 1); // Orden automático 1, 2, 3...
            $paso->setDescripcion($desc);
            $receta->addPaso($paso);
        }

        // Añadir Nutrientes
        foreach ($nutrientesData as $nutData) {
            $recNutri = new RecetaNutriente();
            $recNutri->setTipoNutriente($nutData[0]); // Objeto TipoNutriente
            $recNutri->setCantidad($nutData[1]);
            $receta->addRecetaNutriente($recNutri);
        }

        $manager->persist($receta);
    }
}
