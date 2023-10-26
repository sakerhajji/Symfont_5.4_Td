<?php

namespace App\Entity;

use App\Repository\ReaderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReaderRepository::class)]
class Reader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'readers')]
    private Collection $readerbook;

    public function __construct()
    {
        $this->readerbook = new ArrayCollection();
    }

   

    
    

    

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
    public function __toString()
    {
        return $this->getId() . ' - ' . $this->getUsername();
    }

    /**
     * @return Collection<int, self>
     */


 



    /**
     * @return Collection<int, self>
     */
    public function getReaders(): Collection
    {
        return $this->readers;
    }

    public function addReader(self $reader): static
    {
        if (!$this->readers->contains($reader)) {
            $this->readers->add($reader);
            $reader->addReadbook($this);
        }

        return $this;
    }

    public function removeReader(self $reader): static
    {
        if ($this->readers->removeElement($reader)) {
            $reader->removeReadbook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getReaderbook(): Collection
    {
        return $this->readerbook;
    }

    public function addReaderbook(Book $readerbook): static
    {
        if (!$this->readerbook->contains($readerbook)) {
            $this->readerbook->add($readerbook);
        }

        return $this;
    }

    public function removeReaderbook(Book $readerbook): static
    {
        $this->readerbook->removeElement($readerbook);

        return $this;
    }

    

   

}
