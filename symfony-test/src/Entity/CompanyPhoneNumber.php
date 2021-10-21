<?php

namespace App\Entity;

use App\Repository\CompanyPhoneNumberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyPhoneNumberRepository::class)
 */
class CompanyPhoneNumber
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
    private $company_id;

    /**
     * @ORM\Column(type="integer",unique=true)
     */
    private $phone_number;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="company_phone_numbers")
     */
    private $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyId(): ?int
    {
        return $this->company_id;
    }

    public function setCompanyId(int $company_id): self
    {
        $this->company_id = $company_id;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
