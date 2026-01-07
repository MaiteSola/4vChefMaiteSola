<?php

namespace App\Entity;

use App\Repository\RecetaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetaRepository::class)]
class Receta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titulo = null;

    #[ORM\Column]
    private ?int $comensales = null;

    // --- AQUÍ ESTÁ EL BORRADO LÓGICO ---
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoReceta $tipo = null;

    // --- RELACIONES INVERSAS (Vitales para validaciones) ---
    
    #[ORM\OneToMany(mappedBy: 'receta', targetEntity: Ingrediente::class, orphanRemoval: true)]
    private Collection $ingredientes;

    #[ORM\OneToMany(mappedBy: 'receta', targetEntity: Paso::class, orphanRemoval: true)]
    private Collection $pasos;

    public function __construct()
    {
        // ¡Esto es OBLIGATORIO para relaciones OneToMany!
        $this->ingredientes = new ArrayCollection();
        $this->pasos = new ArrayCollection();
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
                // Como orphanRemoval=true, esto borrará el ingrediente de BBDD si lo quitas de la lista
                // Pero aquí da error porque setReceta no acepta null en Ingrediente.php. 
                // Symfony manejará esto, pero conceptualmente un ingrediente no existe sin receta.
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
}