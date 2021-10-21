<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $last_name;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $doc_number;

    /**
     * @ORM\OneToMany(targetEntity=PersonPhoneNumber::class, mappedBy="person")
     */
    private $phones_numbers_persons;

    
    public function __construct()
    {
        $this->phones_numbers_persons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getDocNumber(): ?int
    {
        return $this->doc_number;
    }

    public function setDocNumber(int $doc_number): self
    {
        $this->doc_number = $doc_number;

        return $this;
    }

    /**
     * @return Collection|PersonPhoneNumber[]
     */
    public function getPhonesNumbersPersons(): Collection
    {
        return $this->phones_numbers_persons;
    }

    public function addPhonesNumbersPerson(PersonPhoneNumber $phonesNumbersPerson): self
    {
        if (!$this->phones_numbers_persons->contains($phonesNumbersPerson)) {
            $this->phones_numbers_persons[] = $phonesNumbersPerson;
            $phonesNumbersPerson->setPerson($this);
        }

        return $this;
    }

    public function removePhonesNumbersPerson(PersonPhoneNumber $phonesNumbersPerson): self
    {
        if ($this->phones_numbers_persons->removeElement($phonesNumbersPerson)) {
            // set the owning side to null (unless already changed)
            if ($phonesNumbersPerson->getPerson() === $this) {
                $phonesNumbersPerson->setPerson(null);
            }
        }

        return $this;
    }

   

    
   
}
