<?php

namespace App\Entity;

use App\Repository\RecetaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: RecetaRepository::class)]
class Receta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['receta:leer'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['receta:leer'])]
    private ?string $titulo = null;

    #[ORM\Column]
    #[Groups(['receta:leer'])]
    #[SerializedName('number-diner')]
    private ?int $comensales = null;

    // --- AQUÍ ESTÁ EL BORRADO LÓGICO ---
    #[ORM\Column(nullable: true)]
    #[Groups(['receta:leer'])]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['receta:leer'])]
    #[SerializedName('type')]
    private ?TipoReceta $tipo = null;

    // --- RELACIONES INVERSAS (Vitales para validaciones) ---

    // AÑADIDO: cascade: ['persist'] para que guarde ingredientes automáticamente
    #[ORM\OneToMany(mappedBy: 'receta', targetEntity: Ingrediente::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['receta:leer'])]
    #[SerializedName('ingredients')]
    private Collection $ingredientes;

    #[ORM\OneToMany(mappedBy: 'receta', targetEntity: RecetaNutriente::class, orphanRemoval: true, cascade: ['persist'])]
    #[Groups(['receta:leer'])]
    #[SerializedName('nutrients')]
    private Collection $recetaNutrientes;

    // AÑADIDO: cascade: ['persist'] para que guarde pasos automáticamente
    #[ORM\OneToMany(mappedBy: 'receta', targetEntity: Paso::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['receta:leer'])]
    #[SerializedName('steps')]
    private Collection $pasos;

    // Relación con valoraciones
    #[ORM\OneToMany(mappedBy: 'receta', targetEntity: Valoracion::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $valoraciones;

    public function __construct()
    {
        // ¡Esto es OBLIGATORIO para relaciones OneToMany!
        $this->ingredientes = new ArrayCollection();
        $this->pasos = new ArrayCollection();
        $this->recetaNutrientes = new ArrayCollection();
        $this->valoraciones = new ArrayCollection();
    }

    // Método para obtener las estadísticas de rating según el YAML
    #[Groups(['receta:leer'])]
    public function getRating(): array
    {
        $totalVotos = $this->valoraciones->count();

        if ($totalVotos === 0) {
            return [
                'number-votes' => 0,
                'rating-avg' => 0
            ];
        }

        $sumaTotal = 0;
        foreach ($this->valoraciones as $valoracion) {
            $sumaTotal += $valoracion->getPuntuacion();
        }

        $promedio = round($sumaTotal / $totalVotos, 1);

        return [
            'number-votes' => $totalVotos,
            'rating-avg' => $promedio
        ];
    }

    // --- GETTERS Y SETTERS BÁSICOS ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function getComensales(): ?int
    {
        return $this->comensales;
    }

    public function setComensales(int $comensales): static
    {
        $this->comensales = $comensales;
        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function getTipo(): ?TipoReceta
    {
        return $this->tipo;
    }

    public function setTipo(?TipoReceta $tipo): static
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return Collection<int, Ingrediente>
     */
    public function getIngredientes(): Collection
    {
        return $this->ingredientes;
    }

    public function addIngrediente(Ingrediente $ingrediente): static
    {
        if (!$this->ingredientes->contains($ingrediente)) {
            $this->ingredientes->add($ingrediente);
            $ingrediente->setReceta($this);
        }
        return $this;
    }

    public function removeIngrediente(Ingrediente $ingrediente): static
    {
        if ($this->ingredientes->removeElement($ingrediente)) {
            // set the owning side to null (unless already changed)
            if ($ingrediente->getReceta() === $this) {
                // Como orphanRemoval=true, esto borrará el ingrediente de BBDD
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Paso>
     */
    public function getPasos(): Collection
    {
        return $this->pasos;
    }

    public function addPaso(Paso $paso): static
    {
        if (!$this->pasos->contains($paso)) {
            $this->pasos->add($paso);
            $paso->setReceta($this);
        }
        return $this;
    }

    public function removePaso(Paso $paso): static
    {
        if ($this->pasos->removeElement($paso)) {
            // Lógica similar a ingredientes
        }
        return $this;
    }

    /**
     * @return Collection<int, RecetaNutriente>
     */
    public function getRecetaNutrientes(): Collection
    {
        return $this->recetaNutrientes;
    }

    public function addRecetaNutriente(RecetaNutriente $recetaNutriente): static
    {
        if (!$this->recetaNutrientes->contains($recetaNutriente)) {
            $this->recetaNutrientes->add($recetaNutriente);
            $recetaNutriente->setReceta($this);
        }

        return $this;
    }

    public function removeRecetaNutriente(RecetaNutriente $recetaNutriente): static
    {
        if ($this->recetaNutrientes->removeElement($recetaNutriente)) {
            // set the owning side to null (unless already changed)
            if ($recetaNutriente->getReceta() === $this) {
                // Como la relación es obligatoria en el hijo, no podemos poner setReceta(null).
                // Pero gracias a orphanRemoval=true, al quitarlo de la lista, Doctrine lo borrará.
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Valoracion>
     */
    public function getValoraciones(): Collection
    {
        return $this->valoraciones;
    }

    public function addValoracion(Valoracion $valoracion): static
    {
        if (!$this->valoraciones->contains($valoracion)) {
            $this->valoraciones->add($valoracion);
            $valoracion->setReceta($this);
        }

        return $this;
    }

    public function removeValoracion(Valoracion $valoracion): static
    {
        if ($this->valoraciones->removeElement($valoracion)) {
            if ($valoracion->getReceta() === $this) {
                $valoracion->setReceta(null);
            }
        }

        return $this;
    }
}
