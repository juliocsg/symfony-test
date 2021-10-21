<?php

namespace App\Entity;

use App\Repository\PersonPhoneNumberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonPhoneNumberRepository::class)
 */
class PersonPhoneNumber
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $person_id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $phone_number;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="phones_numbers_persons")
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonId(): ?int
    {
        return $this->person_id;
    }

    public function setPersonId(int $person_id): self
    {
        $this->person_id = $person_id;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(int $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
