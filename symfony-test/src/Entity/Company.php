<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="company")
     */
    private $employees;

    /**
     * @ORM\OneToMany(targetEntity=CompanyPhoneNumber::class, mappedBy="company")
     */
    private $company_phone_numbers;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->company_phone_numbers = new ArrayCollection();
    }

 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setCompany($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getCompany() === $this) {
                $employee->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompanyPhoneNumber[]
     */
    public function getCompanyPhoneNumbers(): Collection
    {
        return $this->company_phone_numbers;
    }

    public function addCompanyPhoneNumber(CompanyPhoneNumber $companyPhoneNumber): self
    {
        if (!$this->company_phone_numbers->contains($companyPhoneNumber)) {
            $this->company_phone_numbers[] = $companyPhoneNumber;
            $companyPhoneNumber->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyPhoneNumber(CompanyPhoneNumber $companyPhoneNumber): self
    {
        if ($this->company_phone_numbers->removeElement($companyPhoneNumber)) {
            // set the owning side to null (unless already changed)
            if ($companyPhoneNumber->getCompany() === $this) {
                $companyPhoneNumber->setCompany(null);
            }
        }

        return $this;
    }

}
