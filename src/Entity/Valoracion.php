<?php

namespace App\Entity;

use App\Repository\ValoracionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ValoracionRepository::class)]
class Valoracion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['receta:leer'])] // Para ver las valoraciones dentro de la receta si quisieras
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['receta:leer'])]
    private ?int $puntuacion = null;

    #[ORM\Column(length: 45)]
    private ?string $ip = null; // La IP no la solemos enseñar en el JSON público por privacidad

    #[ORM\ManyToOne(inversedBy: 'valoraciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Receta $receta = null;

    // Getters y Setters...
    public function getId(): ?int { return $this->id; }

    public function getPuntuacion(): ?int { return $this->puntuacion; }
    public function setPuntuacion(int $puntuacion): static { $this->puntuacion = $puntuacion; return $this; }

    public function getIp(): ?string { return $this->ip; }
    public function setIp(string $ip): static { $this->ip = $ip; return $this; }

    public function getReceta(): ?Receta { return $this->receta; }
    public function setReceta(?Receta $receta): static { $this->receta = $receta; return $this; }
}