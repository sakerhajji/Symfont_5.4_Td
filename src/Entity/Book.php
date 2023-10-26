<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $publicationDate = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Author $idAuthor = null;

    #[ORM\ManyToMany(targetEntity: Reader::class, mappedBy: 'readerbook')]
    private Collection $readers;

    public function __construct()
    {
        $this->readers = new ArrayCollection();
    }


    

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPublicationDate(): ?string
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(string $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getIdAuthor(): ?Author
    {
        return $this->idAuthor;
    }

    public function setIdAuthor(?Author $idAuthor): static
    {
        $this->idAuthor = $idAuthor;

        return $this;
    }

    /**
     * @return Collection<int, Reader>
     */
    public function getReaders(): Collection
    {
        return $this->readers;
    }

    public function addReader(Reader $reader): static
    {
        if (!$this->readers->contains($reader)) {
            $this->readers->add($reader);
            $reader->addReaderbook($this);
        }

        return $this;
    }

    public function removeReader(Reader $reader): static
    {
        if ($this->readers->removeElement($reader)) {
            $reader->removeReaderbook($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getId() . ' - ' . $this->getTitle()  ;
    }

}
